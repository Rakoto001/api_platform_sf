<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Dependency;
use Ramsey\Uuid\Uuid;

class DependencyDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface, ItemDataProviderInterface
{
    private $projectDir;

    public function __construct(string $projectDir) {
    $this->projectDir = $projectDir;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []){
        // dd($resourceClass, $operationName, $context);
        
        $jsonPath = $this->projectDir.'/composer_test.json';
        $jsonData = json_decode(file_get_contents($jsonPath), true); // true car on a besoin d'un tab associatif
        $dataDependencies = [];
        
        foreach ($jsonData['require'] as $name => $version) {
            
            // $dataDependencies[] = new Dependency(Uuid::uuid5(Uuid::NAMESPACE_URL, $name)->toString(), $name, $version); 
            $dataDependencies[] = new Dependency($name, $version); 
            # code...
        }
        // dd($dataDependencies);


        return $dataDependencies;

        
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool{

        return $resourceClass === Dependency::class;
    }

    /**
     * permet l'opération pour item => avec les $id
     *
     * @param string $resourceClass
     * @param [type] $id
     * @param string $operationName
     * @param array $context
     * @return void
     */
    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []){
        $jsonPath = $this->projectDir.'/composer.json';
        $jsonData = json_decode(file_get_contents($jsonPath), true); // true car on a besoin d'un tab associatif
        $dataDependencies = [];
        
        foreach ($jsonData['require'] as $name => $version) {
            $uuid = Uuid::uuid5(Uuid::NAMESPACE_URL, $name)->toString();

            if ($uuid == $id) {

                return new Dependency($id, $name, $version);
            }

            return null;
            
            # code...
        }
    }
    

}