<?php


namespace App\DataFixtures;


use App\Entity\VillesFranceFree;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

/**
 * Class TaxrefFixtures
 * @package App\DataFixtures
 */
class VillesFranceFixtures extends Fixture
{

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager):void
    {

        foreach (Yaml::parseFile('src/DataFixtures/villes_france_free.yml') as $v) {
            $ville = new VillesFranceFree();
            $ville
                ->setVilleId($v['ville_id'])
                ->setVilleDepartement($v['ville_departement'])
                ->setVilleSlug($v['ville_slug'])
                ->setVilleNom($v['ville_nom'])
                ->setVilleNomSimple($v['ville_nom_simple'])
                ->setVilleNomReel($v['ville_nom_reel'])
                ->setVilleNomSoundex($v['ville_nom_soundex'])
                ->setVilleNomMetaphone($v['ville_nom_metaphone'])
                ->setVilleCodePostal($v['ville_code_postal'])
                ->setVilleCommune($v['ville_commune'])
                ->setVilleCodeCommune($v['ville_code_commune'])
                ->setVilleArrondissement($v['ville_arrondissement'])
                ->setVilleCanton($v['ville_canton'])
                ->setVilleAmdi($v['ville_amdi'])
                ->setVillePopulation2010($v['ville_population_2010'])
                ->setVillePopulation1999($v['ville_population_1999'])
                ->setVillePopulation2012($v['ville_population_2012'])
                ->setVilleDensite2010($v['ville_densite_2010'])
                ->setVilleSurface($v['ville_surface'])
                ->setVilleLongitudeDeg($v['ville_longitude_deg'])
                ->setVilleLatitudeDeg($v['ville_latitude_deg'])
                ->setVilleLongitudeGrd($v['ville_longitude_grd'])
                ->setVilleLatitudeGrd($v['ville_latitude_grd'])
                ->setVilleLongitudeDms($v['ville_longitude_dms'])
                ->setVilleLatitudeDms($v['ville_latitude_dms'])
                ->setVilleZmin($v['ville_zmin'])
                ->setVilleZmax($v['ville_zmax'])
                ;
            $manager->persist($ville);
        }

        $manager->flush();
    }
}