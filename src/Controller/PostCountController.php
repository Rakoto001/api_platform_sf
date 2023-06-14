<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;

class PostCountController
{
    public $posrRepos; 
    public function __construct(PostRepository $posrRepos) {
        $this->posrRepos = $posrRepos;
    }
    public function __invoke(Request $request)
    {

        return $this->posrRepos->count(['online' => $request->get('online')]);
        
    }

}