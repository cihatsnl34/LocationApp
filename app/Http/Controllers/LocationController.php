<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest;
use App\Models\Location;
// use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LocationController extends Controller
{
    //
    public function store(LocationRequest $request)
    {
        $valitaded = $request->validated();
        try {
            $location = Location::create([
                "latitude" => $request->latitude,
                'longitude' => $request->longitude,
                "name" => $request->name,
                "color" => $request->color
            ]);
            if ($location)
                return response()->json(["message" => "Location created"], 201);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }
    public function update(LocationRequest $request, $id)
    {
        $validated = $request->validated();
        try {
            $location = Location::find($id);
            if (empty($location))
                return response()->json(["message" => "Location not found."], 400);
            $location->latitude = $request->latitude;
            $location->longitude = $request->longitude;
            $location->name = $request->name;
            $location->color = $request->color;
            $location->update();
            if ($location)
                return response()->json(["message" => "Location updated"], 200);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }
    public function list()
    {
        $locations = Location::all();
        return response()->json($locations, 200);
    }
    public function select($id)
    {
        $location = Location::find($id);
        if (empty($location))
            return response()->json(["message" => "Location not found."], 400);
        return response()->json($location, 200);
    }
}
