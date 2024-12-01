<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->can('attributes.manage')) {
            $attributes = Attribute::orderBy('created_at', 'asc')->orderBy('name', 'asc')->get();
            return view('backend.admin.product.attribute.index', compact('attributes'));
        } else {
            return redirect()->back()->with('error', 'Permission Denied');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->can('attributes.create')) {
            return view('backend.admin.product.attribute.create');
        } else {
            return redirect()->back()->with('error', 'Permission Denied');
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        return $request;
        $request->validate([
            'name' => 'required',
        ]);
        try {
            DB::beginTransaction();

            $data = $request->all();
            $data['values'] = json_encode($request->values);
            $attribute = Attribute::create($data);
            DB::commit();
            return redirect()->route('admin.product.attributes.index')->with('success', "Attribute Created Successfully");
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
        if (auth()->user()->can('attributes.edit')) {
            $attribute = Attribute::find(decrypt($id));
            if (!$attribute) {
                return back()->with('error', 'Something Went Wrong');
            }
            return view('backend.admin.product.attribute.edit', compact('attribute'));
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
            $attribute = Attribute::findOrFail($id);
            if (!$attribute) {
                return back()->with('error', 'Something Went Wrong');
            }
            $data = $request->all();
            $data['values'] = json_encode($request->values);
            $attribute->update($data);
            DB::commit();
            return redirect()->route('admin.product.attributes.index')->with('success', "Attribute Updated Successfully");
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
        if (auth()->user()->can('attributes.destroy')) {
            $attribute = Attribute::findOrFail(decrypt($id));
            $attribute->delete();
            return redirect()->route('admin.product.attributes.index')->with('success', "Attribute Deleted Successfully");
        } else {
            return redirect()->back()->with('error', 'Permission Denied');
        }

    }

    public function changeActiveStatus(Request $request)
    {

        try {
            // Find the attribute by ID
            $attribute = Attribute::findOrFail($request->attribute_id);

            // Update the 'is_active' status
            $attribute->is_active = $request->is_active;
            $attribute->save();

            // Return a success response
            return response()->json([
                'status' => 'success',
                'message' => 'Active status updated successfully.',
                'is_active' => $attribute->is_active,
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
