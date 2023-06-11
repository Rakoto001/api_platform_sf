<?php
namespace App\Entity;

use Ramsey\Uuid\Uuid;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    itemOperations: [
        'get',
        'put' => 
        ['denormalization_context' => ['groups' => 'put:Dependency']
        ],
        
    ],
    collectionOperations: ['get', 'post']
)]
class Dependency{

    #[ApiProperty(
        identifier: true
        )]
    private $uuid;

    #[ApiProperty(
        description: 'Nom de la dépendance'
        )]
    #[Assert\Length(min: 5)]
    private $name;

     #[ApiProperty(
        description: 'Version de la dépendance',
        openapiContext: [
            'example'=> '5.0.*'
        ]
        )]
    #[Assert\NotBlank(), Length(min: 5)]
    #[Groups(['put:Dependency'])]
    private $version;
   
    public function __construct(string $name, string $version) {
        // $this->uuid = $uuid;
        $this->uuid = Uuid::uuid5(Uuid::NAMESPACE_URL, $name)->toString();
        $this->name = $name;
        $this->version = $version;
    }

    /**
     * Get the value of uuid
     */ 
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Get the value of version
     */ 
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

        /**
         * Get the value of name
         */ 
        public function getName()
        {
                return $this->name;
        }

  

   
}





//  maintenant, COMMENT ON FAIT POUR FAIRE FONCTIONNER LES COLLECTIONOPERATION => c'est la qu'on utlise un dataProvider personalisé