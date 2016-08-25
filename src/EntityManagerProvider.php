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
use Doctrine\ORM\Proxy\ProxyFactory;
use Doctrine\ORM\Tools\Setup;
use Ray\Di\Di\Inject;
use Ray\Di\ProviderInterface;
use Ray\DoctrineOrmModule\Annotation\EntityManagerConfig;
use Ray\DoctrineOrmModule\Annotation\ProxyDir;

class EntityManagerProvider implements ProviderInterface
{
    /**
     * @var array
     */
    private $params;

    /**
     * @var array
     */
    private $entityDir;

    /**
     * @var string
     */
    private $proxyDir;

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
        list($this->params, $entityDir) = $config;
        $this->entityDir = is_array($entityDir) ? $entityDir : [$entityDir];
    }

    /**
     * @param string $dir
     *
     * @ProxyDir
     * @Inject(optional=true)
     */
    public function setProxyDir($dir)
    {
        $this->proxyDir = $dir;
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
        $config = Setup::createAnnotationMetadataConfiguration($this->entityDir);
        $config->setSQLLogger($this->logger);

        if ($this->proxyDir) {
            $config->setProxyDir($this->proxyDir);
            $config->setAutoGenerateProxyClasses(ProxyFactory::AUTOGENERATE_FILE_NOT_EXISTS);
        } else {
            $config->setAutoGenerateProxyClasses(ProxyFactory::AUTOGENERATE_EVAL);
        }

        return EntityManager::create($this->params, $config);
    }
}
