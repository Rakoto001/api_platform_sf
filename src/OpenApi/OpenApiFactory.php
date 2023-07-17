<?php

namespace App\OpenApi;

use ArrayObject;
use ApiPlatform\OpenApi\OpenApi;
use ApiPlatform\OpenApi\Model\PathItem;
use ApiPlatform\OpenApi\Model\RequestBody;
use ApiPlatform\Core\OpenApi\Model\Operation;
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

       $sehmas = $openApi->getComponents()->getSecuritySchemes();

       $sehmas['coockieAuth'] = new ArrayObject(
           [
               'type' => 'apiKey',
               'in' => 'coockie',
               'name' => 'PHPSESSID'
           ]
           );
        
        // $openApi = $openApi->withSecurity(['coockieAuth' => []]);

        $schema = $openApi->getComponents()->getSchemas();
        $schema['Credentials'] = new ArrayObject([
            'type' => 'object',
            'properties' => [
                'username' => [
                    'type' => 'string',
                    'example' => 'exemple@gmail.com',

                ],
                'password' => [
                    'type' => 'text',
                    'exemple' => '0000'
                ]
            ]
        ]);

        $pathItem = new PathItem(
            post: new Operation(
                operationId: 'postLogin',
                requestBody : new RequestBody(
                    content: new ArrayObject([
                        'application/json' => [
                            'schema' => [
                                '$ref' => '#/components/schemas/Credentials'

                            ]
                        ]
                    ])

                ),
                responses: [
                    '200' => [
                        'description' => 'Utilisateur connecté',
                        'content' => [
                            'appication/json' => [
                                'schema' => [
                                    '$ref' => '#/components/schemas/User-read.user'
                                ]
                            ]
                        ]
                    ] 
                ]
            )   

        );

        $openApi->getPaths()->addPath('/api/login', $pathItem);
        
        return $openApi;
    }

}