<?php

namespace App\Services;


use App\Entity\User;
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
            if ($k === $function && in_array('visitor', $v)){
                return true;
            } elseif ($request->getSession()->get('user') !== null){
                if ($k === $function && in_array($request->getSession()->get('user')['role'], $v)){
                    return true;
                }
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

    public function connection($data): ?User
    {
        if (isset($data['email']) && isset($data['password'])){
            $user = $this->userRepository->findOneBy(['email'=>$data['email']]);
            if ($user !== null){
                if($user->getPassword() === md5($data['password'])){
                    $this->flash[] = ['success'=>'Bravo '
                        .$user->getFirstName()
                        .' '
                        .$user->getLastName()
                        .' Vous êtes maintenant <strong>connecté</strong>'];
                    return $user;
                }
                $this->flash[] = ['warning'=>'Votre password est incorrect'];
            }else{
                $this->flash[] = ['warning'=>'l\'email <strong>'.$data['email'].'</strong> n\'existe pas'];
            }
        }
        return null;
    }

    public function disconnect()
    {
        return 'déconnexion';
    }
}