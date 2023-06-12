<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;

class PostCountController
{
    public $posrRepos; 
    public function __construct(PostRepository $posrRepos) {
        $this->posrRepos = $posrRepos;
    }
    public function __invoke()
    {
        // dd('dans COUNT CONTROLLER');

        return $this->posrRepos->count([]);
        
    }

}