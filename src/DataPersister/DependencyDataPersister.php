<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
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
        return true;

    }

    /**
     * {@inheritdoc}
     */
    public function persist($data, array $context = [])
    {
        $this->datareposiroty->save($data);

    }

    /**
     * {@inheritdoc}
     */
    public function remove($data, array $context = [])
    {

    }
}