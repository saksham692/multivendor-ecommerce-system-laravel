<?php

namespace App\Http\Controllers;

use App\DataTables\ProductDataTable;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Label;
use App\Models\Product;
use App\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductDataTable $dataTable)
    {
        if (!auth()->user()->can('products.manage')) {
            return redirect()->back()->with('error', 'Permission Denied');
        }
        return $dataTable->render('backend.admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('products.create')) {
            return redirect()->back()->with('error', 'Permission Denied');
        }
        $attributes = Attribute::where('is_active', 1)->orderBy('name', 'asc')->get();
        $categories = Category::whereNull('parent_id')->orderBy('name', 'asc')->get();
        $collections = Collection::where('is_active', 1)->orderBy('name', 'asc')->get();
        $labels = Label::where('is_active', 1)->orderBy('name', 'asc')->get();
        return view('backend.admin.product.create', compact('categories', 'collections', 'attributes', 'labels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'nullable|exists:brands,id',
            'description' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'thumbnail_img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sku' => 'nullable|string|max:255',
            'price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'current_stock' => 'nullable|numeric',
            'barcode' => 'nullable|string|max:255',
            'stock_status' => 'required|string|in:in_stock,out_of_stock',
            'wholesale_prices' => 'nullable|array',
            'wholesale_prices.*.min_qty' => 'required|integer',
            'wholesale_prices.*.max_qty' => 'nullable|integer',
            'wholesale_prices.*.price' => 'required|numeric',
//            'taxes' => 'nullable|array',
//            'taxes.*.name' => 'required|string|max:255',
//            'taxes.*.value' => 'required|numeric',
            'weight' => 'nullable|numeric',
            'length' => 'nullable|numeric',
            'width' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:160',
        ]);
//        return $request;
        // Create the product
        $product = new Product();
        $product->is_featured = $request->input('is_featured');
        $product->is_active = $request->input('is_active');
        $product->name = $request->input('name');
        $product->brand_id = $request->input('brand_id');
        $product->description = $request->input('description');
        //price and stock
        $product->sku = $request->input('sku');
        $product->price = $request->input('price');
        $product->discount_price = $request->input('discount_price');
        $product->current_stock = $request->input('current_stock');
        $product->barcode = $request->input('barcode');
        $product->stock_status = $request->input('stock_status') == 'in_stock' ? 1 : 0;
        //Shipping
        $product->weight = $request->input('weight');
        $product->length = $request->input('length');
        $product->width = $request->input('width');
        $product->height = $request->input('height');
        //SEO
        $product->seo_title = $request->input('seo_title');
        $product->seo_description = $request->input('seo_description');
        $product->tags = $request->input('tags');

        // Handle file uploads
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $file) {
                $path = $file->store('products/images', 'public');
                $images[] = $path;
            }
            $product->images = implode(',', $images);
        }

        if ($request->hasFile('thumbnail_img')) {
            $thumbnailPath = $request->file('thumbnail_img')->store('products/thumbnails', 'public');
            $product->thumbnail_img = $thumbnailPath;
        }

        //Attributes
        $processedAttributes = [];
//        if ($request->has('attributes')) {
//            foreach ($request->input('attributes') as $key => $attribute) {
//                // Check if attribute_name is not null or empty
//                if (!empty($attribute['attribute_name'])) {
//                    $processedValues = [];
//
//                    // Loop through values and remove null/empty ones
//                    foreach ($attribute['values'] as $key2 => $value) {
//                        if (!empty($value)) {
//                            $processedValues[] = $value;
//                        }
//                    }
//
//                    // If there are valid values, add the attribute to the final array
//                    if (!empty($processedValues)) {
//                        $processedAttributes[] = [
//                            'attribute_name' => $attribute['attribute_name'],
//                            'values' => $processedValues,
//                        ];
//                    }
//                }
//            }
//        }
////        return $processedAttributes;
//        $product->attributes = json_encode($processedAttributes);
        // Save the product
        $product->save();

        // Attach relationships
        if ($request->has('collections')) {
            $product->collections()->attach($request->input('collections'));
        }

        if ($request->has('categories')) {
            $product->categories()->attach($request->input('categories'));
        }

        if ($request->has('labels')) {
            $product->labels()->attach($request->input('labels'));
        }

        // Save wholesale prices
        if ($request->has('wholesale_prices')) {
            foreach ($request->input('wholesale_prices') as $wholesale) {
                if ($wholesale['min_qty'] != null && $wholesale['max_qty'] != null && $wholesale['price']) {
                    $product->wholesales()->create([
                        'min_qty' => $wholesale['min_qty'],
                        'max_qty' => $wholesale['max_qty'],
                        'price' => $wholesale['price'],
                    ]);
                }
            }
        }

        // Save taxes
//        if ($request->has('taxes')) {
//            foreach ($request->input('taxes') as $tax) {
//                if ($tax['name'] != null && $tax['value'] != null) {
//                    $product->taxes()->create([
//                        'name' => $tax['name'],
//                        'value' => $tax['value'],
//                    ]);
//                }
//            }
//        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
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
        if (!auth()->user()->can('products.edit')) {
            return redirect()->back()->with('error', 'Permission Denied');
        }
        $product = Product::find(decrypt($id));
        $product->selectedCategoryIds = $product->categories->pluck('id')->toArray();
        $product->selectedCollectionIds = $product->collections->pluck('id')->toArray();
        $product->selectedlabelIds = $product->labels->pluck('id')->toArray();

        $attributes = Attribute::where('is_active', 1)->orderBy('name', 'asc')->get();
        $categories = Category::whereNull('parent_id')->orderBy('name', 'asc')->get();
        $collections = Collection::where('is_active', 1)->orderBy('name', 'asc')->get();
        $labels = Label::where('is_active', 1)->orderBy('name', 'asc')->get();

//        return $product;
        if (!$product) {
            return back()->with('error', 'Something Went Wrong');
        }
        return view('backend.admin.product.edit', compact('product', 'attributes', 'categories', 'collections', 'labels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the product
        $product = Product::findOrFail($id);
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'nullable|exists:brands,id',
            'description' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'thumbnail_img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sku' => 'nullable|string|max:255',
            'price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'current_stock' => 'nullable|numeric',
            'barcode' => 'nullable|string|max:255',
            'stock_status' => 'required|string|in:in_stock,out_of_stock',
            'wholesale_prices' => 'nullable|array',
            'wholesale_prices.*.min_qty' => 'required|integer',
            'wholesale_prices.*.max_qty' => 'nullable|integer',
            'wholesale_prices.*.price' => 'required|numeric',
            'weight' => 'nullable|numeric',
            'length' => 'nullable|numeric',
            'width' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:160',
        ]);
        // Update product details
        $product->is_featured = $request->input('is_featured');
        $product->is_active = $request->input('is_active');
        $product->name = $request->input('name');
        $product->brand_id = $request->input('brand_id');
        $product->description = $request->input('description');
        $product->sku = $request->input('sku');
        $product->price = $request->input('price');
        $product->discount_price = $request->input('discount_price');
        $product->current_stock = $request->input('current_stock');
        $product->barcode = $request->input('barcode');
        $product->stock_status = $request->input('stock_status') == 'in_stock' ? 1 : 0;
        $product->weight = $request->input('weight');
        $product->length = $request->input('length');
        $product->width = $request->input('width');
        $product->height = $request->input('height');
        $product->seo_title = $request->input('seo_title');
        $product->seo_description = $request->input('seo_description');
        $product->tags = $request->input('tags');

        // Handle file uploads
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $file) {
                $path = $file->store('products/images', 'public');
                $images[] = $path;
            }
            $product->images = implode(',', $images);
        }

        if ($request->hasFile('thumbnail_img')) {
            $thumbnailPath = $request->file('thumbnail_img')->store('products/thumbnails', 'public');
            $product->thumbnail_img = $thumbnailPath;
        }

        // Attributes
        $processedAttributes = [];
//        if ($request->has('attributes')) {
//            foreach ($request->input('attributes') as $key => $attribute) {
//                if (!empty($attribute['attribute_name'])) {
//                    $processedValues = [];
//                    foreach ($attribute['values'] as $key2 => $value) {
//                        if (!empty($value)) {
//                            $processedValues[] = $value;
//                        }
//                    }
//                    if (!empty($processedValues)) {
//                        $processedAttributes[] = [
//                            'attribute_name' => $attribute['attribute_name'],
//                            'values' => $processedValues,
//                        ];
//                    }
//                }
//            }
//        }
//        $product->attributes = json_encode($processedAttributes);

        // Save the product
        $product->save();

        // Update relationships
        $product->collections()->sync($request->input('collections', []));
        $product->categories()->sync($request->input('categories', []));
        $product->labels()->sync($request->input('labels', []));

        // Update wholesale prices
        $product->wholesales()->delete();  // Remove old wholesale prices
        if ($request->has('wholesale_prices')) {
            foreach ($request->input('wholesale_prices') as $wholesale) {
                if ($wholesale['min_qty'] != null && $wholesale['max_qty'] != null && $wholesale['price']) {
                    $product->wholesales()->create([
                        'min_qty' => $wholesale['min_qty'],
                        'max_qty' => $wholesale['max_qty'],
                        'price' => $wholesale['price'],
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!auth()->user()->can('products.destroy')) {
            return redirect()->back()->with('error', 'Permission Denied');
        }
        $product = Product::findOrFail(decrypt($id));
        if ($product->is_active == 1) {
            return back()->with('error', 'This Product Can\'t be deleted');
        }
        if ($product->thumbnail_img != null && $product->thumbnail_img != '' && is_numeric($product->thumbnail_img)) {
            Storage::disk('public')->delete($product->thumbnail_img);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', "Product Deleted Successfully");
    }

    public function getAttributeValues(Request $request)
    {
        try {
            // Find the attribute by ID
            $attribute = Attribute::findOrFail($request->attribute_id);

            // Return a success response
            return response()->json([
                'status' => 'success',
                'message' => 'Values get successfully.',
                'attribute_values' => json_decode($attribute->values),
            ]);

        } catch (\Exception $e) {
            // Handle any errors and return an error response
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }

    }

    public function changeActiveStatus(Request $request)
    {

        try {
            // Find the product by ID
            $product = Product::findOrFail($request->product_id);

            // Update the 'is_active' status
            $product->is_active = $request->is_active;
            $product->save();

            // Return a success response
            return response()->json([
                'status' => 'success',
                'message' => 'Active status updated successfully.',
                'is_active' => $product->is_active,
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
