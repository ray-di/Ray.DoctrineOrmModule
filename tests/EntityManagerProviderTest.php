<?php

namespace Ray\DoctrineOrmModule;

use Doctrine\ORM\EntityManagerInterface;
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

        $this->assertNull($instance->getConfiguration()->getSQLLogger());
    }

    public function testProviderWithLogger()
    {
        $this->provider->setSqlLogger(new PsrSqlLogger(new FakeLogger));
        $instance = $this->provider->get();
        /* @var $instance EntityManagerInterface */

        $this->assertInstanceOf(EntityManagerInterface::class, $instance);
        $this->assertTrue($this->isEntityClassLoaded($instance, FakeUser::class));

        $this->assertInstanceOf(PsrSqlLogger::class, $instance->getConfiguration()->getSQLLogger());
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
