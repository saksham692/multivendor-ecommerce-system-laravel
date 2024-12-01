<?php

namespace App\Http\Controllers;

use App\DataTables\PermissionDataTable;
use App\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PermissionDataTable $dataTable)
    {
        if (!auth()->user()->can('permissions.manage')) {
            return redirect()->back()->with('error', 'Permission Denied');
        }
        return $dataTable->render('backend.admin.user.permission.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('permissions.create')) {
            return redirect()->back()->with('error', 'Permission Denied');
        }
        return view('backend.admin.user.permission.create');
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
            $permission = Permission::create($data);
            DB::commit();
            return redirect()->route('admin.permissions.index')->with('success', "Permission Created Successfully");
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
        if (!auth()->user()->can('permissions.edit')) {
            return redirect()->back()->with('error', 'Permission Denied');
        }
        $permission = Permission::find(decrypt($id));
        if (!$permission) {
            return back()->with('error', 'Something Went Wrong');
        }
        return view('backend.admin.user.permission.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $permission = Permission::findOrFail($id);
            if (!$permission) {
                return back()->with('error', 'Something Went Wrong');
            }
            $request->validate([
                'name' => 'required',
            ]);
            $data = $request->all();
            $permission->slug = null;
            $permission->update($data);
            DB::commit();
            return redirect()->route('admin.permissions.index')->with('success', "Permission Updated Successfully");
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
        if (!auth()->user()->can('permissions.destroy')) {
            return redirect()->back()->with('error', 'Permission Denied');
        }
        $permission = Permission::findOrFail(decrypt($id));
        if ($permission->roles != null) {
            return back()->with('error', 'This Permission Can\'t be deleted');
        }
        $permission->delete();
        return redirect()->route('admin.permissions.index')->with('success', "Permission Deleted Successfully");
    }

    public function changeFeaturedStatus(Request $request)
    {
        try {
            // Find the permission by ID
            $permission = Permission::findOrFail($request->permission_id);

            // Update the 'is_featured' status
            $permission->is_featured = $request->is_featured;
            $permission->save();

            // Return a success response
            return response()->json([
                'status' => 'success',
                'message' => 'Featured status updated successfully.',
                'is_featured' => $permission->is_featured,
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
            // Find the permission by ID
            $permission = Permission::findOrFail($request->permission_id);

            // Update the 'is_active' status
            $permission->is_active = $request->is_active;
            $permission->save();

            // Return a success response
            return response()->json([
                'status' => 'success',
                'message' => 'Active status updated successfully.',
                'is_active' => $permission->is_active,
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
