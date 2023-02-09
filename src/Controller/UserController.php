<?php

namespace App\Controller;

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
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'users'=>$users,
        ]);
    }
}
