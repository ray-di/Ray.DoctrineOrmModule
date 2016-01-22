<?php

namespace Ray\DoctrineOrmModule;

use Doctrine\ORM\EntityManagerInterface;
use Ray\Compiler\DiCompiler;
use Ray\Di\Injector;
use Ray\DoctrineOrmModule\Entity\FakeUser;

class EntityManagerModuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EntityManagerModule
     */
    private $module;

    public function setUp()
    {
        parent::setUp();
        $this->module = new EntityManagerModule(['driver' => 'pdo_sqlite', 'memory' => true], [__DIR__ . '/Fake/Entity/']);
    }

    public function testModule()
    {
        $instance = (new Injector($this->module, $_ENV['TMP_DIR']))->getInstance(EntityManagerInterface::class);
        /* @var $instance EntityManagerInterface */
        $this->assertInstanceOf(EntityManagerInterface::class, $instance);
        $this->assertTrue($this->isEntityClassLoaded($instance, FakeUser::class));
    }

    public function testCompile()
    {
        (new DiCompiler($this->module, $_ENV['TMP_DIR']))->compile();
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
