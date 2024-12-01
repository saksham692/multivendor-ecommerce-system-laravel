<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Label;
use App\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->can('brands.manage')) {
            $brands = Brand::orderBy('created_at', 'asc')->orderBy('name', 'asc')->get();
            return view('backend.admin.product.brand.index', compact('brands'));
        } else {
            return redirect()->back()->with('error', 'Permission Denied');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->can('brands.create')) {
            return view('backend.admin.product.brand.create');
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
            ]);
            $data = $request->all();
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('brands', 'public');
                $data['logo'] = $logoPath;
            }

            $brand = Brand::create($data);
            DB::commit();
            return redirect()->route('admin.product.brands.index')->with('success', "Brand Created Successfully");
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
        if (auth()->user()->can('brands.edit')) {
            $brand = Brand::find(decrypt($id));
            if (!$brand) {
                return back()->with('error', 'Something Went Wrong');
            }
            return view('backend.admin.product.brand.edit', compact('brand'));
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
            $brand = Brand::findOrFail($id);
            if (!$brand) {
                return back()->with('error', 'Something Went Wrong');
            }
            $request->validate([
                'name' => 'required',
            ]);
            $data = $request->all();
            if ($request->hasFile('logo')) {
                if ($brand->logo != null && $brand->logo != '')
                    Storage::disk('public')->delete($brand->logo);
                $logoPath = $request->file('logo')->store('brands', 'public');
                $data['logo'] = $logoPath;
            }
            $brand->slug = null;
            $brand->update($data);
            DB::commit();
            return redirect()->route('admin.product.brands.index')->with('success', "Brand Updated Successfully");
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
        if (auth()->user()->can('brands.destroy')) {
            $brand = Brand::findOrFail(decrypt($id));
            if ($brand->products != null) {
                return back()->with('error', 'This Brand Can\'t be deleted');
            }
            $brand->delete();
            return redirect()->route('admin.product.brands.index')->with('success', "Brand Deleted Successfully");
        } else {
            return redirect()->back()->with('error', 'Permission Denied');
        }
    }

    public function changeFeaturedStatus(Request $request)
    {
        try {
            // Find the brand by ID
            $brand = Brand::findOrFail($request->brand_id);

            // Update the 'is_featured' status
            $brand->is_featured = $request->is_featured;
            $brand->save();

            // Return a success response
            return response()->json([
                'status' => 'success',
                'message' => 'Featured status updated successfully.',
                'is_featured' => $brand->is_featured,
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
            // Find the brand by ID
            $brand = Brand::findOrFail($request->brand_id);

            // Update the 'is_active' status
            $brand->is_active = $request->is_active;
            $brand->save();

            // Return a success response
            return response()->json([
                'status' => 'success',
                'message' => 'Active status updated successfully.',
                'is_active' => $brand->is_active,
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
