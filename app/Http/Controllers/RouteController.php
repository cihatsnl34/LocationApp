<?php

namespace App\Http\Controllers;

use App\Helper\Calculate;
use App\Http\Requests\RouteRequest;
use App\Models\Location;
use Illuminate\Routing\Controller;

class RouteController extends Controller
{
    public function route(RouteRequest $request)
    {
        $valitaded = $request->validated();
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
