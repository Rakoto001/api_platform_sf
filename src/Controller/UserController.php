<?php
namespace App\Controller;

use App\Entity\Post;
use Symfony\Component\Security\Core\Security;

class UserController
{
    public function __invoke(Security $secu) 
    {
        $user = $secu->getUser();

        return $user;
    }
    
}