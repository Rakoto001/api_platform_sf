<?php
namespace App\Controller;

use App\Entity\Post;

class PostPublishController
{
    public function __invoke(Post $oPost) :Post
    {
        $oPost->setOnline(!$oPost->setOnline);
        
        return $oPost;
    }
    
}