<?php

namespace App\Controller;

use App\Controller\UserController;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(UserRepository $userRepo): Response
    {
        $users=$userRepo->findAll();
        $this->transformRoles($users);
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'users'=>$users,
        ]);
    }
    private function transformRoles(array $users){
        foreach ($users as $user){
            $roles=$user->getRoles();
            $roleStr="";
            foreach($roles as $role){
                switch($role){
                    case 'ROLE_USER':
                        $roleStr.="utilisateur ";
                        break;
                    case 'ROLE_ADMIN':
                        $roleStr .= "administrateur ";
                        break;
                }
            }
        $user->roleStr=$roleStr;
        }
    }
}
