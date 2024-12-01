<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->can('labels.manage')) {
            return redirect()->back()->with('error', 'Permission Denied');
        }
        $labels = Label::orderBy('created_at', 'asc')->orderBy('name', 'asc')->get();
        return view('backend.admin.product.label.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('labels.create')) {
            return redirect()->back()->with('error', 'Permission Denied');
        }
        return view('backend.admin.product.label.create');
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
            $label = Label::create($data);
            DB::commit();
            return redirect()->route('admin.product.labels.index')->with('success', "Label Created Successfully");
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
        if (!auth()->user()->can('labels.edit')) {
            return redirect()->back()->with('error', 'Permission Denied');
        }
        $label = Label::find(decrypt($id));
        if (!$label) {
            return back()->with('error', 'Something Went Wrong');
        }
        return view('backend.admin.product.label.edit', compact('label'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $label = Label::findOrFail($id);
            if (!$label) {
                return back()->with('error', 'Something Went Wrong');
            }
            $request->validate([
                'name' => 'required',
            ]);
            $data = $request->all();
            $label->slug = null;
            $label->update($data);
            DB::commit();
            return redirect()->route('admin.product.labels.index')->with('success', "Label Updated Successfully");
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
        if (!auth()->user()->can('labels.destroy')) {
            return redirect()->back()->with('error', 'Permission Denied');
        }
        $label = Label::findOrFail(decrypt($id));
        if ($label->products != null) {
            return back()->with('error', 'This Label Can\'t be deleted');
        }
        $label->delete();
        return redirect()->route('admin.product.labels.index')->with('success', "Label Deleted Successfully");
    }

    public function changeFeaturedStatus(Request $request)
    {
        try {
            // Find the label by ID
            $label = Label::findOrFail($request->label_id);

            // Update the 'is_featured' status
            $label->is_featured = $request->is_featured;
            $label->save();

            // Return a success response
            return response()->json([
                'status' => 'success',
                'message' => 'Featured status updated successfully.',
                'is_featured' => $label->is_featured,
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
            // Find the label by ID
            $label = Label::findOrFail($request->label_id);

            // Update the 'is_active' status
            $label->is_active = $request->is_active;
            $label->save();

            // Return a success response
            return response()->json([
                'status' => 'success',
                'message' => 'Active status updated successfully.',
                'is_active' => $label->is_active,
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
