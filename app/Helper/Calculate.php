<?php

namespace App\Helper;

class Calculate
{
    static function calculateDistance($latitude1, $longitude1, $latitude2, $longitude2)
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
