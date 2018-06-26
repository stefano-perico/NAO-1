<?php


namespace App\DataFixtures;


use App\Entity\Image;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Yaml\Yaml;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class TaxrefFixtures
 * @package App\DataFixtures
 */
class UserFixtures extends Fixture implements DependentFixtureInterface
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

    public function getDependencies()
    {
        return [
            ImageFixtures:class
        ];
    }
}