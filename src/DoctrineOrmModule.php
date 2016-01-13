<?php
/**
 * This file is part of the Ray.DoctrineOrmModule package
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Ray\DoctrineOrmModule;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Ray\Di\AbstractModule;
use Ray\Di\Scope;
use Ray\DoctrineOrmModule\Annotation\DoctrineOrmConfig;

class DoctrineOrmModule extends AbstractModule
{
    /**
     * Constructor.
     *
     * @param array $params
     * @param array $paths
     */
    public function __construct(array $params, array $paths)
    {
        parent::__construct();

        AnnotationRegistry::registerFile(__DIR__ . '/DoctrineAnnotations.php');
        $this->bind()->annotatedWith(DoctrineOrmConfig::class)->toInstance([$params, $paths]);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->bind(EntityManagerInterface::class)->toProvider(DoctrineOrmProvider::class)->in(Scope::SINGLETON);
    }
}
