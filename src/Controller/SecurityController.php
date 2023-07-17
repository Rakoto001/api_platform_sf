<?php
namespace App\Controller;

use App\Entity\Post;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
    #[Route(path:'/api/login', name:'api_login', methods:['POST'])]
    public function login() :Response
    {
        $oUser = $this->getUser();

        return $this->json([
            'username' => $oUser->getUserName(),
            'roles' => $oUser->getRoles()
            ]);
    }
    
}