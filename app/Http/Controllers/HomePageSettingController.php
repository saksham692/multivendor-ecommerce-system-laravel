<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EmailConfiguration;
use App\Models\GeneralSetting;
use App\Models\HomePageSetting;
use App\Models\LogoSetting;
use App\Models\PusherSetting;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HomePageSettingController extends Controller
{
    use ImageUploadTrait;

    public function index()
    {
        $mainBanners = HomePageSetting::where('key', 'main_banner')->get();
        $bannerSectionOne = HomePageSetting::where('key', 'banner_section_one')->first();
        $bannerSectionTwo = HomePageSetting::where('key', 'banner_section_two')->first();
        $bannerSectionThree = HomePageSetting::where('key', 'banner_section_three')->first();
        $bannerSectionFour = HomePageSetting::where('key', 'banner_section_four')->first();
        return view('backend.admin.home-page-setting.index', compact('mainBanners', 'bannerSectionOne', 'bannerSectionTwo', 'bannerSectionThree', 'bannerSectionFour'));
    }


    public function main_banner_add(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'url' => 'required|url|max:255', // Validate URL
            'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate image
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422); // HTTP status 422: Unprocessable Entity
        }

        try {
            // Handle the image upload
            $banner = $request->file('banner');
            $bannerName = 'main_banner_' . time() . '.' . $banner->getClientOriginalExtension();
            $bannerPath = $banner->storeAs('banners', $bannerName, 'public'); // Store image in the `public/banners` directory

            // Save the banner information in the database
            $ordering = HomePageSetting::where('key', 'main_banner')->count();
            $value = json_encode([
                'url' => $request->url,
                'banner' => $bannerPath,
            ]);

            $data = HomePageSetting::create([
                'key' => 'main_banner',
                'value' => $value,
                'ordering' => $ordering + 1
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Banner added successfully!',
                'banner' => asset('storage/' . $bannerPath),
                'data' => $data,
                'url' => $request->url,
                'delete_url' => '', // Add a delete route if needed
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while adding the banner.',
                'error' => $e->getMessage(),
            ], 500); // HTTP status 500: Internal Server Error
        }
    }

//    public function main_banner_edit(Request $request)
//    {
//        try {
//            // Find the banner
//            $banner = HomePageSetting::findOrFail($request->id);
//
//            // Decode the banner value
//            $bannerData = json_decode($banner->value);
//
//            // Generate HTML for editing (optional for inline editing)
//            $html = <<<HTML
//        <input type="hidden" name="id" value="{$banner->value}">
//                <div class="col-sm-12 form-group">
//                    <label class="form-label">URL</label>
//                    <input class="form-control" type="text" name="url"
//                           value="{$bannerData->url}"/>
//                    <span id="url-error" class="error text-danger"></span>
//                </div>
//            </div>
//        HTML;
//
//            return response()->json([
//                'status' => 'success',
//                'html' => $html,
//                'data' => $banner
//            ]);
//        } catch (\Exception $e) {
//            return response()->json([
//                'status' => 'error',
//                'message' => 'Failed to load banner data.',
//                'error' => $e->getMessage()
//            ], 500);
//        }
//    }

    public function main_banner_remove(Request $request)
    {
        try {
            // Find the banner by ID
            $banner = HomePageSetting::findOrFail($request->id);

            // Decode the banner value to access the file path
            $bannerData = json_decode($banner->value);

            // Delete the banner file from storage
            if (isset($bannerData->banner) && \Storage::disk('public')->exists($bannerData->banner)) {
                \Storage::disk('public')->delete($bannerData->banner);
            }

            // Delete the record from the database
            $banner->delete();

            // Reorder the remaining banners
            $banners = HomePageSetting::where('key', 'main_banner')
                ->orderBy('ordering', 'asc')
                ->get();

            foreach ($banners as $index => $remainingBanner) {
                $remainingBanner->update(['ordering' => $index + 1]); // Start from 1
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Banner removed successfully and order updated!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to remove the banner.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function banner_section_one(Request $request)
    {
        // Validate the input
//        return $request;
        $validator = Validator::make($request->all(), [
            'banner' => ['nullable', 'image', 'max:3000'], // Banner is optional, must be an image, max size 3MB
            'url' => ['required', 'url'], // Ensure URL is valid
        ]);

        if ($validator->fails()){
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }
        try {
            $bannerPath = $request->banner_old; // Default to old banner if no new banner is provided

            // Handle the banner upload
            if ($request->hasFile('banner')) {
                // If there's an old banner, delete it
                if (!is_null($request->banner_old)) {
                    Storage::disk('public')->delete($request->banner_old);
                }

                // Store the new banner
                $banner = $request->file('banner');
                $bannerName = 'banner_section_one_' . time() . '.' . $banner->getClientOriginalExtension();
                $bannerPath = $banner->storeAs('banners', $bannerName, 'public');
            }

            // Prepare the value to be saved
            $value = json_encode([
                'status' => $request->status == 'on' ? 1 : 0,
                'banner' => $bannerPath,
                'url' => $request->url,
            ]);

            // Create or update the banner section record
            HomePageSetting::updateOrCreate(
                ['key' => 'banner_section_one'], // Unique key for the section
                ['value' => $value]
            );

            return response()->json(['status' => 'success', 'bannerPath' => asset('storage/'.$bannerPath), 'banner' => $bannerPath, 'message' => 'Updated Successfully'], 200);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function banner_section_two(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'banner_one' => ['nullable', 'image', 'max:3000'], // Optional image, max size 3MB
            'banner_two' => ['nullable', 'image', 'max:3000'], // Optional image, max size 3MB
            'banner_one_url' => ['required', 'url'], // Required valid URL
            'banner_two_url' => ['required', 'url'], // Required valid URL
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        try {
            $bannerOnePath = $request->banner_one_old;
            $bannerTwoPath = $request->banner_two_old;

            // Handle the first banner upload
            if ($request->hasFile('banner_one')) {
                // Delete old banner if exists
                if (!is_null($request->banner_one_old)) {
                    Storage::disk('public')->delete($request->banner_one_old);
                }

                // Store the new banner
                $bannerOne = $request->file('banner_one');
                $bannerOneName = 'banner_section_two_banner_one_' . time() . '.' . $bannerOne->getClientOriginalExtension();
                $bannerOnePath = $bannerOne->storeAs('banners', $bannerOneName, 'public');
            }

            // Handle the second banner upload
            if ($request->hasFile('banner_two')) {
                // Delete old banner if exists
                if (!is_null($request->banner_two_old)) {
                    Storage::disk('public')->delete($request->banner_two_old);
                }

                // Store the new banner
                $bannerTwo = $request->file('banner_two');
                $bannerTwoName = 'banner_section_two_banner_two_' . time() . '.' . $bannerTwo->getClientOriginalExtension();
                $bannerTwoPath = $bannerTwo->storeAs('banners', $bannerTwoName, 'public');
            }

            // Prepare banner data
            $banners = [
                [
                    'status' => $request->banner_one_status === 'on' ? 1 : 0,
                    'banner' => $bannerOnePath,
                    'url' => $request->banner_one_url,
                ],
                [
                    'status' => $request->banner_two_status === 'on' ? 1 : 0,
                    'banner' => $bannerTwoPath,
                    'url' => $request->banner_two_url,
                ]
            ];

            // Save the data
            HomePageSetting::updateOrCreate(
                ['key' => 'banner_section_two'], // Unique key for the section
                ['value' => json_encode($banners)] // Save as JSON
            );

            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => 'Updated Successfully',
                'bannerOnePath' => asset('storage/' . $bannerOnePath),
                'banner_one' => $bannerOnePath,
                'bannerTwoPath' => asset('storage/' . $bannerTwoPath),
                'banner_two' => $bannerTwoPath,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function banner_section_three(Request $request)
    {
        // Validate the input
//        return $request;
        $validator = Validator::make($request->all(), [
            'banner' => ['nullable', 'image', 'max:3000'], // Banner is optional, must be an image, max size 3MB
            'url' => ['required', 'url'], // Ensure URL is valid
        ]);

        if ($validator->fails()){
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }
        try {
            $bannerPath = $request->banner_old; // Default to old banner if no new banner is provided

            // Handle the banner upload
            if ($request->hasFile('banner')) {
                // If there's an old banner, delete it
                if (!is_null($request->banner_old)) {
                    Storage::disk('public')->delete($request->banner_old);
                }

                // Store the new banner
                $banner = $request->file('banner');
                $bannerName = 'banner_section_three_' . time() . '.' . $banner->getClientOriginalExtension();
                $bannerPath = $banner->storeAs('banners', $bannerName, 'public');
            }

            // Prepare the value to be saved
            $value = json_encode([
                'status' => $request->status == 'on' ? 1 : 0,
                'banner' => $bannerPath,
                'url' => $request->url,
            ]);

            // Create or update the banner section record
            HomePageSetting::updateOrCreate(
                ['key' => 'banner_section_three'], // Unique key for the section
                ['value' => $value]
            );

            return response()->json(['status' => 'success', 'bannerPath' => asset('storage/'.$bannerPath), 'banner' => $bannerPath, 'message' => 'Updated Successfully'], 200);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function banner_section_four(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'banner_one' => ['nullable', 'image', 'max:3000'], // Optional image, max size 3MB
            'banner_two' => ['nullable', 'image', 'max:3000'], // Optional image, max size 3MB
            'banner_one_url' => ['required', 'url'], // Required valid URL
            'banner_two_url' => ['required', 'url'], // Required valid URL
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        try {
            $bannerOnePath = $request->banner_one_old;
            $bannerTwoPath = $request->banner_two_old;

            // Handle the first banner upload
            if ($request->hasFile('banner_one')) {
                // Delete old banner if exists
                if (!is_null($request->banner_one_old)) {
                    Storage::disk('public')->delete($request->banner_one_old);
                }

                // Store the new banner
                $bannerOne = $request->file('banner_one');
                $bannerOneName = 'banner_section_four_banner_one_' . time() . '.' . $bannerOne->getClientOriginalExtension();
                $bannerOnePath = $bannerOne->storeAs('banners', $bannerOneName, 'public');
            }

            // Handle the second banner upload
            if ($request->hasFile('banner_two')) {
                // Delete old banner if exists
                if (!is_null($request->banner_two_old)) {
                    Storage::disk('public')->delete($request->banner_two_old);
                }

                // Store the new banner
                $bannerTwo = $request->file('banner_two');
                $bannerTwoName = 'banner_section_four_banner_two_' . time() . '.' . $bannerTwo->getClientOriginalExtension();
                $bannerTwoPath = $bannerTwo->storeAs('banners', $bannerTwoName, 'public');
            }

            // Prepare banner data
            $banners = [
                [
                    'status' => $request->banner_one_status === 'on' ? 1 : 0,
                    'banner' => $bannerOnePath,
                    'url' => $request->banner_one_url,
                ],
                [
                    'status' => $request->banner_two_status === 'on' ? 1 : 0,
                    'banner' => $bannerTwoPath,
                    'url' => $request->banner_two_url,
                ]
            ];

            // Save the data
            HomePageSetting::updateOrCreate(
                ['key' => 'banner_section_four'], // Unique key for the section
                ['value' => json_encode($banners)] // Save as JSON
            );

            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => 'Updated Successfully',
                'bannerOnePath' => asset('storage/' . $bannerOnePath),
                'banner_one' => $bannerOnePath,
                'bannerTwoPath' => asset('storage/' . $bannerTwoPath),
                'banner_two' => $bannerTwoPath,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }



}
