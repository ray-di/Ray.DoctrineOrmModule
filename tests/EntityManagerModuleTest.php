<?php

namespace Ray\DoctrineOrmModule;

use Doctrine\DBAL\Logging\SQLLogger;
use Doctrine\ORM\EntityManagerInterface;
use Ray\Compiler\DiCompiler;
use Ray\Di\Injector;
use Ray\DoctrineOrmModule\Entity\FakeUser;

class EntityManagerModuleTest extends \PHPUnit_Framework_TestCase
{
    public function testModule()
    {
        $instance = (new Injector(new FakeAppModule, $_ENV['TMP_DIR']))->getInstance(EntityManagerInterface::class);
        /* @var $instance EntityManagerInterface */

        $this->assertInstanceOf(EntityManagerInterface::class, $instance);
        $this->assertTrue($this->isEntityClassLoaded($instance, FakeUser::class));

        $this->assertNull($instance->getConfiguration()->getSQLLogger());
    }

    public function testCompile()
    {
        (new DiCompiler(new FakeAppModule, $_ENV['TMP_DIR']))->compile();
    }

    public function testModuleWithLogger()
    {
        $instance = (new Injector(new FakeLoggableAppModule, $_ENV['TMP_DIR']))->getInstance(EntityManagerInterface::class);
        /* @var $instance EntityManagerInterface */

        $this->assertInstanceOf(EntityManagerInterface::class, $instance);
        $this->assertTrue($this->isEntityClassLoaded($instance, FakeUser::class));

        $this->assertInstanceOf(SQLLogger::class, $instance->getConfiguration()->getSQLLogger());
    }

    public function testCompileWithLogger()
    {
        (new DiCompiler(new FakeLoggableAppModule, $_ENV['TMP_DIR']))->compile();
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
