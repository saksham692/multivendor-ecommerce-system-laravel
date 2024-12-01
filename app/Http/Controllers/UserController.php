<?php

namespace App\Http\Controllers;

use App\DataTables\PermissionDataTable;
use App\DataTables\UserDataTable;
use App\Models\Seller;
use App\Models\Upload;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserDataTable $dataTable)
    {
        if (!auth()->user()->can('users.manage')) {
            return redirect()->back()->with('error', 'Permission Denied');
        }
        return $dataTable->render('backend.admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('users.create')) {
            return redirect()->back()->with('error', 'Permission Denied');
        }
        return view('backend.admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:200'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password_confirmation' => ['required', 'min:8'],
            'password' => ['required', 'min:8', 'confirmed'],
            'role' => ['required']
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->is_active = 1;
        $user->save();

        if ($request->role === 'seller' || $request->role === 'admin') {
            $seller = new Seller();
            $seller->user_id = $user->id;
            $seller->shop_name = $request->name . ' Shop';
            $seller->email = $request->email;
            $seller->status = 1;
            $seller->save();
        }

//            Mail::to($request->email)->send(new AccountCreatedMail($request->name, $request->email, $request->password));
        return redirect()->back()->with('success', 'User Created Successfully');
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
        if (!auth()->user()->can('users.edit')) {
            return redirect()->back()->with('error', 'Permission Denied');
        }
        $user = User::find(decrypt($id));
        if (!$user) {
            return back()->with('error', 'Something Went Wrong');
        }
        return view('backend.admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $user = User::findOrFail($id);
            if (!$user) {
                return back()->with('error', 'Something Went Wrong');
            }
            $request->validate([
                'name' => 'required',
            ]);
            $data = $request->all();
            $user->slug = null;
            $user->update($data);
            DB::commit();
            return redirect()->route('admin.users.index')->with('success', "User Updated Successfully");
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
        if (!auth()->user()->can('users.destroy')) {
            return redirect()->back()->with('error', 'Permission Denied');
        }
        $user = User::findOrFail(decrypt($id));
        if ($user->role != null) {
            return back()->with('error', 'This User Can\'t be deleted');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', "User Deleted Successfully");
    }

}
