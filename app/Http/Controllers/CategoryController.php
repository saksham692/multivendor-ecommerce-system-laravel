<?php

namespace App\Http\Controllers;

use App\DataTables\CategoryDataTable;
use App\Models\Category;
use App\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryDataTable $dataTable)
    {
        if (auth()->user()->can('categories.manage')) {
            return $dataTable->render('backend.admin.product.category.index');
        } else {
            return redirect()->back()->with('error', 'Permission Denied');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->can('categories.create')) {
            return view('backend.admin.product.category.create');
        } else {
            return redirect()->back()->with('error', 'Permission Denied');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'name' => 'required',
                'icon' => 'required',
                'thumbnail_img' => 'required|image',
            ]);
            $data = $request->all();
            $file = $request->file('thumbnail_img');

            $timestamp = now()->format('YmdHis');
            $extension = $file->getClientOriginalExtension();
            $filename = $timestamp . '.' . $extension;
            $size = formatFileSize($file->getSize());

            $path = $file->storeAs('uploads/categories', $filename, 'public');
//            $upload = new Upload();
//            $upload->path = $path;
//            $upload->size = $size;
//            $upload->name = $filename;
//            $upload->save();

            $data['thumbnail_img'] = $path;
//            $data['thumbnail_img'] = $upload->id;
            $category = Category::create($data);
            DB::commit();
            return redirect()->route('admin.product.categories.index')->with('success', "Category Created Successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (auth()->user()->can('categories.edit')) {
            $category = Category::find(decrypt($id));
            if (!$category) {
                return back()->with('error', 'Something Went Wrong');
            }
            return view('backend.admin.product.category.edit', compact('category'));
        } else {
            return redirect()->back()->with('error', 'Permission Denied');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $category = Category::findOrFail($id);
            if (!$category) {
                return back()->with('error', 'Something Went Wrong');
            }
            $request->validate([
                'name' => 'required',
                'icon' => 'required',
                'thumbnail_img' => 'nullable|image',
            ]);
            $data = $request->all();
            if ($request->file('thumbnail_img') != null) {
                if ($category->thumbnail_img != null || $category->thumbnail_img != '') {
                    Storage::disk('public')->delete($category->thumbnail_img);
                }
                $file = $request->file('thumbnail_img');

                $timestamp = now()->format('YmdHis');
                $extension = $file->getClientOriginalExtension();
                $filename = $timestamp . '.' . $extension;
                $path = $file->storeAs('uploads/categories', $filename, 'public');
            } else {
                $path = $category->path;
            }
            $data['thumbnail_img'] = $path;
            $category->slug = null;
            $category->update($data);
            DB::commit();
            return redirect()->route('admin.product.categories.index')->with('success', "Category Updated Successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (auth()->user()->can('categories.destroy')) {
            $category = Category::findOrFail(decrypt($id));
            if ($category->childrens != null) {
                return back()->with('error', 'This Category Can\'t be deleted');
            }
            if ($category->thumbnail_img != null && $category->thumbnail_img != '' && is_numeric($category->thumbnail_img)) {
                $previousThumbnail = Upload::find($category->thumbnail_img);
                Storage::disk('public')->delete($previousThumbnail->path);
                $previousThumbnail->delete();
            }
            $category->delete();
            return redirect()->route('admin.product.categories.index')->with('success', "Category Deleted Successfully");
        } else {
            return redirect()->back()->with('error', 'Permission Denied');
        }
    }

    public function changeActiveStatus(Request $request)
    {

        try {
            // Find the category by ID
            $category = Category::findOrFail($request->category_id);

            // Update the 'is_active' status
            $category->is_active = $request->is_active;
            $category->save();

            // Return a success response
            return response()->json([
                'status' => 'success',
                'message' => 'Active status updated successfully.',
                'is_active' => $category->is_active,
            ]);

        } catch (\Exception $e) {
            // Handle any errors and return an error response
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

}
