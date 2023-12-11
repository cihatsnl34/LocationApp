<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    //
    public function store(Request $request)
    {
        $rules = [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'name' => 'required|string',
            'color' => 'required|string|max:7',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        $location = Location::create($request->all());
        return response()->json(["message" => "Location created"], 201);
    }
    public function update(Request $request, $id)
    {
        $rules = [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'name' => 'required|string',
            'color' => 'required|string|max:7',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $location = Location::find($id);
        if (empty($location))
            return response()->json(["message" => "Location not found."], 400);
        $location->update($request->all());

        return response()->json(["message" => "Location updated"], 200);
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
