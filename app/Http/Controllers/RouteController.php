<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class RouteController extends Controller
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

        $locations = Location::all();
        if (empty($locations))
            return response()->json(["message" => "Location not found."], 400);
        //Kullanıcının girdiği konum ile sistemdeki diğer konumlar arasındaki mesafeleri hesaplayalım
        $distances = [];
        foreach ($locations as $location) {
            $distance = $this->calculateDistance($request->latitude, $request->longitude, $location->latitude, $location->longitude);
            $distances[$location->id] = $distance;
        }

        //Mesafelere göre konumları sıralayalım
        asort($distances);

        //Sıralanmış konumları rota olarak oluşturalım
        $route = [];
        foreach ($distances as $locationId => $distance) {
            $location = Location::findOrFail($locationId);
            $route[] = [
                'id' => $location->id,
                'name' => $location->name,
                'latitude' => $location->latitude,
                'longitude' => $location->longitude,
                'distance' => $distance,
            ];
        }

        return response()->json($route, 200);
    }
    private function calculateDistance($latitude1, $longitude1, $latitude2, $longitude2)
    {
        $r = 6371; //Dünya'nın yarıçapı(km)
        $phi1 = deg2rad($latitude1);
        $phi2 = deg2rad($latitude2);
        $deltaPhi = deg2rad($latitude2 - $latitude1);
        $deltaLambda = deg2rad($longitude2 - $longitude1);

        $a = sin($deltaPhi / 2) * sin($deltaPhi / 2) + cos($phi1) * cos($phi2) * sin($deltaLambda / 2) * sin($deltaLambda / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $mesafe = $r * $c;

        return $mesafe;
    }
}
