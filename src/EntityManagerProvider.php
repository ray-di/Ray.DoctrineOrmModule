<?php
/**
 * This file is part of the Ray.DoctrineOrmModule package
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Ray\DoctrineOrmModule;

use Doctrine\DBAL\Logging\SQLLogger;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;
use Ray\Di\Di\Inject;
use Ray\Di\ProviderInterface;
use Ray\DoctrineOrmModule\Annotation\EntityManagerConfig;

class EntityManagerProvider implements ProviderInterface
{
    /**
     * @var array
     */
    private $params;

    /**
     * @var array
     */
    private $paths;

    /**
     * @var SQLLogger
     */
    private $logger;

    /**
     * Constructor.
     *
     * @param array $config
     *
     * @EntityManagerConfig
     */
    public function __construct(array $config)
    {
        list($this->params, $this->paths) = $config;
    }

    /**
     * @param SQLLogger $logger
     *
     * @Inject(optional=true)
     */
    public function setSqlLogger(SQLLogger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     *
     * @return EntityManagerInterface
     */
    public function get()
    {
        $config = Setup::createAnnotationMetadataConfiguration($this->paths);
        $config->setSQLLogger($this->logger);

        return EntityManager::create($this->params, $config);
    }
}
