<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Get states by country ID.
     *
     * @param int $country_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStatesByCountry(Request $request)
    {
        // Fetch states based on the selected country
        $states = State::where('country_id', $request->country_id)->get();

        // Return states as JSON response
        return response()->json($states);
    }

    /**
     * Get cities by state ID.
     *
     * @param int $state_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCitiesByState(Request $request)
    {
        // Fetch cities based on the selected state
        $cities = City::where('state_id', $request->state_id)->get();

        // Return cities as JSON response
        return response()->json($cities);
    }
}
