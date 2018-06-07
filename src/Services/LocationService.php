<?php

namespace App\Services;


use App\Repository\VillesFranceFreeRepository;

class LocationService
{

    private $villesFranceFreeRepository;

    public function __construct(VillesFranceFreeRepository $villesFranceFreeRepository)
    {
        $this->villesFranceFreeRepository = $villesFranceFreeRepository;
    }
    
    public function getAllBy($type,$name)
    {
        return $this->villesFranceFreeRepository->findBy([$type=>$name]);
    }

    public function distanceBetwenVille($villeA,$villeB)
    {
        $villeA = $this->villesFranceFreeRepository->findOneBy(['villeNom'=>$villeA]);
        $villeB = $this->villesFranceFreeRepository->findOneBy(['villeNom'=>$villeB]);
        if (!empty($villeA && $villeB) && null !== $villeA && null !== $villeB){
            $distance = $this->calculationDistance(
                $villeA->getVilleLatitudeDeg(),
                $villeA->getVilleLongitudeDeg(),
                $villeB->getVilleLatitudeDeg(),
                $villeB->getVilleLongitudeDeg(),
                'K'
            );
            if (!empty($distance) && $distance !== null) {
                return $distance;
            } else {
                return null;
            }
        }
    }

    public function distanceToVille($latitude, $longitude, $ville)
    {
        $ville = $this->villesFranceFreeRepository->findOneBy(['villeNom'=>$ville]);
        if (!empty($ville) && null !== $ville){
            $distance = $this->calculationDistance(
                $latitude,
                $longitude,
                $ville->getVilleLatitudeDeg(),
                $ville->getVilleLongitudeDeg(),
                'K'
            );
            if (!empty($distance) && $distance !== null) {
                return $distance;
            } else {
                return null;
            }
        }
    }

    private function calculationDistance($lat1, $lon1, $lat2, $lon2, $unit) {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit === "K") {
            return ($miles * 1.609344);
        } else if ($unit === "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }



}