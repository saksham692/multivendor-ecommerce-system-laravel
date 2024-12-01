<?php

namespace App\Http\Controllers;

use App\DataTables\PendingSellerDataTable;
use App\DataTables\SellerDataTable;
use App\Models\Seller;
use App\Models\Upload;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SellerDataTable $dataTable)
    {
        if (!auth()->user()->can('sellers.manage')) {
            return redirect()->back()->with('error', 'Permission Denied');
        }
        return $dataTable->render('backend.admin.adminseller.index');
    }

    public function pendingSellers(PendingSellerDataTable $dataTable)
    {
        if (!auth()->user()->can('sellers.manage')) {
            return redirect()->back()->with('error', 'Permission Denied');
        }
        return $dataTable->render('backend.admin.adminseller.pending');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('sellers.create')) {
            return redirect()->back()->with('error', 'Permission Denied');
        }
        return view('backend.admin.adminseller.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        return $request;
        $request->validate([
            'name' => ['required', 'max:200'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required'],
            'password_confirmation' => ['required', 'min:8'],
            'password' => ['required', 'min:8', 'confirmed'],
            'shop_name' => ['req    uired'],
            'description' => ['nullable'],
            'address' => ['required'],
            'country_id' => ['required'],
            'state_id' => ['required'],
            'city_id' => ['required'],
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->user_role = $request->role;
        $user->is_active = 1;

        if ($user->save()) {
            $user->assignRole($request->role);
            $seller = new Seller();
            $seller->user_id = $user->id;
            $seller->shop_name = $request->shop_name;
            $seller->email = $request->email;
            $seller->phone = $request->phone;
            $seller->description = $request->description;
            $seller->address = $request->address;
            $seller->country_id = $request->country_id;
            $seller->state_id = $request->state_id;
            $seller->city_id = $request->city_id;
            $seller->status = 1;
            $seller->save();
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }

//            Mail::to($request->email)->send(new AccountCreatedMail($request->name, $request->email, $request->password));
        return redirect()->back()->with('success', 'Seller Created Successfully');
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
        if (!auth()->user()->can('sellers.edit')) {
            return redirect()->back()->with('error', 'Permission Denied');
        }
        $seller = Seller::find(decrypt($id));
        if (!$seller) {
            return back()->with('error', 'Something Went Wrong');
        }
        return view('backend.admin.adminseller.edit', compact('seller'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $seller = Seller::findOrFail($id);
            if (!$seller) {
                return back()->with('error', 'Something Went Wrong');
            }
            $request->validate([
                'name' => ['required', 'max:200'],
                'email' => ['required', 'email', 'unique:users,email,'.$seller->user->id],
                'phone' => ['required'],
                'password' => ['nullable', 'min:8', 'confirmed'],
                'password_confirmation' => ['required_with:password'],
                'shop_name' => ['required'],
                'description' => ['nullable'],
                'address' => ['required'],
                'country_id' => ['required'],
                'state_id' => ['required'],
                'city_id' => ['required'],
            ]);

            $user = $seller->user;
            $user->name = $request->name;
            $user->email = $request->email;
            if ($user->password != null) {
                $user->password = Hash::make($request->password);
            }
            $user->is_active = 1;

            if ($user->save()) {
                if ($request->hasFile('banner')) {
                    // Check if there is an old banner and delete it
                    $oldBanner = $seller->banner;
                    if (!is_null($oldBanner)) {
                        Storage::disk('public')->delete($oldBanner);
                    }

                    // Store the new banner in the "sellers/banners" folder within the "public" disk
                    $banner = $request->file('banner')->store('sellers/banners', 'public');
                    $seller->banner = $banner;
                }

                $seller->shop_name = $request->shop_name;
                $seller->email = $request->email;
                $seller->phone = $request->phone;
                $seller->description = $request->description;
                $seller->address = $request->address;
                $seller->country_id = $request->country_id;
                $seller->state_id = $request->state_id;
                $seller->city_id = $request->city_id;
                $seller->status = 1;
                $seller->save();
            } else {
                return redirect()->back()->with('error', 'Something went wrong');
            }
            DB::commit();
            return redirect()->back()->with('success', "Seller Updated Successfully");
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
        if (!auth()->user()->can('sellers.destroy')) {
            return redirect()->back()->with('error', 'Permission Denied');
        }
        $seller = Seller::findOrFail(decrypt($id));
        if ($seller->role != null) {
            return back()->with('error', 'This Seller Can\'t be deleted');
        }
        $seller->delete();
        return redirect()->route('admin.sellers.index')->with('success', "Seller Deleted Successfully");
    }

    public function approveSeller(Request $request){
        $seller = Seller::findOrFail($request->seller_id);
        if ($seller){
            $seller->is_approved = 1;
            $seller->save();
            return response()->json(['status' => 'success', 'message' =>  'Seller approved successfully'], 200);
        }
        return response()->json(['status' => 'error', 'message' =>  'Something went wrong'], 500);
    }

    public function rejectSeller(Request $request){
        $seller = Seller::findOrFail($request->seller_id);
        if ($seller){
            $seller->is_approved = -1;
            $seller->save();
            return response()->json(['status' => 'success', 'message' =>  'Seller rejected successfully'], 200);
        }
        return response()->json(['status' => 'error', 'message' =>  'Something went wrong'], 500);
    }

    public function sellerProfile(string $id)
    {
        $seller = Seller::where('user_id', decrypt($id))->first();
        if (!$seller) {
            return back()->with('error', 'Something Went Wrong');
        }
        return view('backend.admin.adminseller.profile', compact('seller'));
    }


}
