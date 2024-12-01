<?php

namespace App\Http\Controllers;

use App\DataTables\PageDataTable;
use App\Models\Page;
use App\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PageDataTable $dataTable)
    {
        if (!auth()->user()->can('pages.manage')) {
            return redirect()->back()->with('error', 'Permission Denied');
        }
        return $dataTable->render('backend.admin.page.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('pages.create')) {
            return redirect()->back()->with('error', 'Permission Denied');
        }
        return view('backend.admin.page.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        return $request;
//        try {
            DB::beginTransaction();

            $request->validate([
                'title' => 'required',
                'content' => 'required',
            ]);
            $data = $request->all();
            $page = Page::create($data);
            DB::commit();
            return redirect()->route('admin.pages.index')->with('success', "Page Created Successfully");
//        } catch (\Exception $e) {
//            DB::rollBack();
//            return back()->with('error', $e->getMessage());
//        }
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        // Fetch the page by its slug
        $page = Page::where('slug', $slug)->firstOrFail();

        return view('pages.show', ['page' => $page]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!auth()->user()->can('pages.edit')) {
            return redirect()->back()->with('error', 'Permission Denied');
        }
        $page = Page::find(decrypt($id));
        if (!$page) {
            return back()->with('error', 'Something Went Wrong');
        }
        return view('backend.admin.page.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $page = Page::findOrFail($id);
            if (!$page) {
                return back()->with('error', 'Something Went Wrong');
            }
            $request->validate([
                'title' => 'required',
                'content' => 'required',
            ]);
            $data = $request->all();
            $page->slug = null;
            $page->update($data);
            DB::commit();
            return redirect()->route('admin.pages.index')->with('success', "Page Updated Successfully");
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
        if (!auth()->user()->can('pages.destroy')) {
            return redirect()->back()->with('error', 'Permission Denied');
        }
        $page = Page::findOrFail(decrypt($id));
        if ($page->products != null) {
            return back()->with('error', 'This Page Can\'t be deleted');
        }
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', "Page Deleted Successfully");
    }

    public function changeFeaturedStatus(Request $request)
    {
        try {
            // Find the page by ID
            $page = Page::findOrFail($request->page_id);

            // Update the 'is_featured' status
            $page->is_featured = $request->is_featured;
            $page->save();

            // Return a success response
            return response()->json([
                'status' => 'success',
                'message' => 'Featured status updated successfully.',
                'is_featured' => $page->is_featured,
            ]);

        } catch (\Exception $e) {
            // Handle any errors and return an error response
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating the featured status.',
            ], 500);
        }
    }

    public function changeActiveStatus(Request $request)
    {

        try {
            // Find the page by ID
            $page = Page::findOrFail($request->page_id);

            // Update the 'is_active' status
            $page->is_active = $request->is_active;
            $page->save();

            // Return a success response
            return response()->json([
                'status' => 'success',
                'message' => 'Active status updated successfully.',
                'is_active' => $page->is_active,
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
