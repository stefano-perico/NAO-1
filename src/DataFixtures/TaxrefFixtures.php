<?php


namespace App\DataFixtures;


use App\Entity\Taxref;
use Symfony\Component\Yaml\Yaml;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class TaxrefFixtures
 * @package App\DataFixtures
 */
class TaxrefFixtures extends Fixture
{

    public function load(ObjectManager $manager):void
    {

        foreach (Yaml::parseFile('src/DataFixtures/taxref.yml') as $v) {
            $taxref = new Taxref();

            $taxref
                ->setFamille($v['famille'])
                ->setLbNom($v['lb_nom'])
                ->setNomFr($v['nom_fr'])
            ;
            $manager->persist($taxref);
        }

        $manager->flush();
    }
}