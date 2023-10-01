<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/{id}', name: 'app_user')]
    public function detail(UserRepository $userRepository, int $id): Response
    {
        $user = $userRepository
        ->find($id);
        return $this->render('user/index.html.twig', [
            'user' => $user,
        ]);
    }
}
