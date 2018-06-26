<?php


namespace App\DataFixtures;


use App\Entity\User;
use Symfony\Component\Yaml\Yaml;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class ImageFixtures
 * @package App\DataFixtures
 */
class ImageFixtures extends Fixture
{

    public function load(ObjectManager $manager):void
    {

        foreach (Yaml::parseFile('src/DataFixtures/Users.yml') as $v) {
            $user = new User();

            $user
                ->setRole($v['role'])
                ->setFirstName($v['firstName'])
                ->setLastName($v['lastName'])
                ->setEmail($v['email'])
                ->setPassword($v['password'])
                ->setRegistrationDate(new \DateTime($v['registrationDate']))
                ->setSummary($v['summary'])
                //todo: Ajouter article
                //todo: Ajouter event
                //todo: Ajouter image
            ;
            $manager->persist($user);
        }

        $manager->flush();
    }

}