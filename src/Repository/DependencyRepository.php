<?php

namespace App\Repository;

use App\Entity\Dependency;

class DependencyRepository
{

    private $projectDir;

    public function __construct($projectDir) {
        $this->projectDir = $projectDir;
    }

    public function save($data)
    {
       $composerDir = $this->projectDir.'/composer_test.json';
       $jsonData = json_decode(file_get_contents($composerDir), true); // true car on a besoin d'un tab associatif
       $oDependency = new Dependency($data->getName(), $data->getVersion());
       $jsonData['require'][$oDependency->getName()] = $oDependency->getVersion();
       file_put_contents($composerDir, json_encode($jsonData, JSON_PRETTY_PRINT |  JSON_UNESCAPED_SLASHES));

    }

}