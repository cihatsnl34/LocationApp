<?php

namespace App\Http\Controllers;

use App\Helper\Calculate;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;

class RouteController extends BaseController
{
    public function route(Request $request)
    {
        $rules = [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        $locations = Location::all()->toArray();

        $distances = collect($locations)->map(function ($location) use ($request) {
            return [
                'id' => $location['id'],
                'distance' => Calculate::calculateDistance($request->latitude, $request->longitude, $location['latitude'], $location['longitude'])
            ];
        });
        $sortedLocations = $distances->sortBy('distance')->values()->all();

        $route = collect($sortedLocations)->map(function ($sortedLocation) {
            $location = Location::findOrFail($sortedLocation['id']);
            return [
                'id' => $location->id,
                'name' => $location->name,
                'latitude' => $location->latitude,
                'longitude' => $location->longitude,
                'distance' => $sortedLocation['distance'],
            ];
        })->all();
        return response()->json($route, 200);
    }
}
