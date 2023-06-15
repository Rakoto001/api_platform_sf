<?php

namespace App\OpenApi;

use ApiPlatform\OpenApi\OpenApi;
use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;

class OpenApiFactory implements OpenApiFactoryInterface
{

    private $decorator;

    public function __construct(OpenApiFactoryInterface $decorator) 
    {
        $this->decorator = $decorator;

    }
    public function __invoke(array $context = []): OpenApi
    {
       $openApi = $this->decorator->__invoke($context);
       foreach ($openApi->getPaths()->getPaths() as $key => $path) {

        if ( $path->getGet() && $path->getGet()->getSummary() === 'hidden') {
            $openApi->getPaths()->addPath($key, $path->withGet(null));
        }

        // dd($path->getGet()->getSummary());
           # code...
       }
        
        return $openApi;
    }

}