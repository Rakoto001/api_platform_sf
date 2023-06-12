<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Dependency;
use App\Repository\DependencyRepository;

class DependencyDataPersister implements ContextAwareDataPersisterInterface
{
    private $datareposiroty;

    public function __construct(DependencyRepository $datareposiroty) {
        $this->datareposiroty = $datareposiroty;
    }
      /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Dependency;

    }

    /**
     * {@inheritdoc}
     */
    public function persist($data, array $context = [])
    {
        if ( $data instanceof Dependency) {

            $this->datareposiroty->save($data);
        }

    }

    /**
     * {@inheritdoc}
     */
    public function remove($data, array $context = [])
    {

    }
}