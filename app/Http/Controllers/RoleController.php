<?php

namespace App\Http\Controllers;

use App\DataTables\RoleDataTable;
use App\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RoleDataTable $dataTable)
    {
        if (auth()->user()->can('roles.manage')) {
            return $dataTable->render('backend.admin.admin.user.role.index');
        } else {
            return redirect()->back()->with('error', 'Permission Denied');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->can('roles.create')) {
            return view('backend.admin.admin.user.role.create');
        } else {
            return redirect()->back()->with('error', 'Permission Denied');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $data = $request->all();
            $role = Role::create($data);
            DB::commit();
            return redirect()->route('admin.roles.index')->with('success', "Role Created Successfully");
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
        if (auth()->user()->can('roles.edit')) {
            $role = Role::find(decrypt($id));
            if (!$role) {
                return back()->with('error', 'Something Went Wrong');
            }
            return view('backend.admin.user.role.edit', compact('role'));
        } else {
            return redirect()->back()->with('error', 'Permission Denied');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $role = Role::findOrFail($id);
            if (!$role) {
                return back()->with('error', 'Something Went Wrong');
            }
            $data = $request->all();
            $role->update($data);
            DB::commit();
            return redirect()->route('admin.roles.index')->with('success', "Role Updated Successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }

    }

    public function assignPermissions(Request $request, string $id)
    {
        if (auth()->user()->can('roles.assignPermissions')) {
            $role = Role::find(decrypt($id));
            $permissions = Permission::orderBy('name', 'asc')->get();
            $rolePermissions = $role->permissions->pluck('id')->toArray();
            return view('backend.admin.user.role.permissions', compact('role', 'permissions', 'rolePermissions'));
        } else {
            return redirect()->back()->with('error', 'Permission Denied');
        }
    }

    public function updatePermissions(Request $request, Role $role)
    {
        // Validate the request
        $validated = $request->validate([
            'permissions' => 'array|required',
        ]);

        // Sync the permissions for the role
        $role->permissions()->sync($validated['permissions']);

        // Redirect back with success message
        return redirect()->route('admin.roles.permissions.assign', encrypt($role->id))->with('success', 'Permissions successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (auth()->user()->can('roles.destroy')) {
            $role = Role::findOrFail(decrypt($id));
            if ($role->permissions != null) {
                return back()->with('error', 'This Role Can\'t be deleted');
            }
            $role->delete();
            return redirect()->route('admin.roles.index')->with('success', "Role Deleted Successfully");
        } else {
            return redirect()->back()->with('error', 'Permission Denied');
        }
    }


}
