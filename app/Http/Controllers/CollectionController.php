<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->can('collections.manage')) {
            return redirect()->back()->with('error', 'Permission Denied');
        }
        $collections = Collection::orderBy('created_at', 'asc')->orderBy('name', 'asc')->get();
        return view('backend.admin.product.collection.index', compact('collections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('collections.create')) {
            return redirect()->back()->with('error', 'Permission Denied');
        }
        return view('backend.admin.product.collection.create');
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
            ]);
            $data = $request->all();
            $collection = Collection::create($data);
            DB::commit();
            return redirect()->route('admin.product.collections.index')->with('success', "Collection Created Successfully");
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
        if (!auth()->user()->can('collections.edit')) {
            return redirect()->back()->with('error', 'Permission Denied');
        }
        $collection = Collection::find(decrypt($id));
        if (!$collection) {
            return back()->with('error', 'Something Went Wrong');
        }
        return view('backend.admin.product.collection.edit', compact('collection'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $collection = Collection::findOrFail($id);
            if (!$collection) {
                return back()->with('error', 'Something Went Wrong');
            }
            $request->validate([
                'name' => 'required',
            ]);
            $data = $request->all();
            $collection->slug = null;
            $collection->update($data);
            DB::commit();
            return redirect()->route('admin.product.collections.index')->with('success', "Collection Updated Successfully");
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
        if (!auth()->user()->can('collections.destroy')) {
            return redirect()->back()->with('error', 'Permission Denied');
        }
        $collection = Collection::findOrFail(decrypt($id));
        if ($collection->products != null) {
            return back()->with('error', 'This Collection Can\'t be deleted');
        }
        $collection->delete();
        return redirect()->route('admin.product.collections.index')->with('success', "Collection Deleted Successfully");
    }

    public function changeFeaturedStatus(Request $request)
    {
        try {
            // Find the collection by ID
            $collection = Collection::findOrFail($request->collection_id);

            // Update the 'is_featured' status
            $collection->is_featured = $request->is_featured;
            $collection->save();

            // Return a success response
            return response()->json([
                'status' => 'success',
                'message' => 'Featured status updated successfully.',
                'is_featured' => $collection->is_featured,
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
            // Find the collection by ID
            $collection = Collection::findOrFail($request->collection_id);

            // Update the 'is_active' status
            $collection->is_active = $request->is_active;
            $collection->save();

            // Return a success response
            return response()->json([
                'status' => 'success',
                'message' => 'Active status updated successfully.',
                'is_active' => $collection->is_active,
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
