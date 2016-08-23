<?php

namespace Ray\DoctrineOrmModule;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Proxy\ProxyFactory;
use Ray\DoctrineOrmModule\Entity\FakeUser;
use Ray\DoctrineOrmModule\Logger\PsrSqlLogger;

class EntityManagerProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EntityManagerProvider
     */
    private $provider;

    public function setUp()
    {
        parent::setUp();
        $this->provider = new EntityManagerProvider([['driver' => 'pdo_sqlite', 'memory' => true], [__DIR__ . '/Fake/Entity/']]);
    }

    public function testProvider()
    {
        $instance = $this->provider->get();
        /* @var $instance EntityManagerInterface */

        $this->assertInstanceOf(EntityManagerInterface::class, $instance);
        $this->assertTrue($this->isEntityClassLoaded($instance, FakeUser::class));

        $config = $instance->getConfiguration();

        $this->assertNull($config->getSQLLogger());
        $this->assertEquals(sys_get_temp_dir(), $config->getProxyDir()); // proxy dir is set, but is never used
        $this->assertEquals(ProxyFactory::AUTOGENERATE_EVAL, $config->getAutoGenerateProxyClasses());
    }

    public function testProviderWithOptionalInject()
    {
        $proxyDir = $_ENV['TMP_DIR'] . '/proxy';

        $this->provider->setProxyDir($proxyDir);
        $this->provider->setSqlLogger(new PsrSqlLogger(new FakeLogger));
        $instance = $this->provider->get();
        /* @var $instance EntityManagerInterface */

        $this->assertInstanceOf(EntityManagerInterface::class, $instance);
        $this->assertTrue($this->isEntityClassLoaded($instance, FakeUser::class));

        $config = $instance->getConfiguration();

        $this->assertInstanceOf(PsrSqlLogger::class, $config->getSQLLogger());
        $this->assertEquals($proxyDir, $config->getProxyDir());
        $this->assertEquals(ProxyFactory::AUTOGENERATE_FILE_NOT_EXISTS, $config->getAutoGenerateProxyClasses());
    }

    /**
     * @param EntityManagerInterface $entityManager EntityManager
     * @param string                 $entityClass   entity class name with namespace
     *
     * @return bool true if entity class is loaded
     */
    private function isEntityClassLoaded(EntityManagerInterface $entityManager, $entityClass)
    {
        $entityManager->getMetadataFactory()->getAllMetadata();

        return in_array($entityClass, get_declared_classes());
    }
}
