<?php

namespace App\Services;


use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

class UserService
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    private $flash = [];

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function isAuthorized(Request $request, string $function)
    {
        foreach (Yaml::parseFile('../src/ressources/RoutesAvaible.yaml') as $k => $v){
            if ($k === $function && in_array($request->getSession()->get('user')['role'], $v)){
                return true;
            }
        }
        $this->flash[] = ['danger'=>'Vous ne pouvez pas accéder à cette page car vous n\'avez pas les autorisations nécessaires'];
        return false;
    }

    public function getFlash()
    {
        return $this->flash;
    }

    public function createAccount()
    {
        return 'création du compte';
    }

    public function deleteAccount()
    {
        return 'suppresion du compte';
    }

    public function updateAccount()
    {
        return 'update du compte';
    }

    public function connection()
    {
        return 'connexion';
    }

    public function disconnect()
    {
        return 'déconnexion';
    }
}