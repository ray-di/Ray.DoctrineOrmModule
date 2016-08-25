<?php
/**
 * This file is part of the Ray.DoctrineOrmModule package
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Ray\DoctrineOrmModule;

use Doctrine\ORM\EntityManagerInterface;
use Ray\Di\AbstractModule;
use Ray\Di\Scope;
use Ray\DoctrineOrmModule\Annotation\EntityManagerConfig;

class EntityManagerModule extends AbstractModule
{
    /**
     * Constructor.
     *
     * @param array        $params
     * @param array|string $entityDir
     */
    public function __construct(array $params, $entityDir)
    {
        parent::__construct();
        $this->bind()->annotatedWith(EntityManagerConfig::class)->toInstance([$params, $entityDir]);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->bind(EntityManagerInterface::class)->toProvider(EntityManagerProvider::class)->in(Scope::SINGLETON);
    }
}
