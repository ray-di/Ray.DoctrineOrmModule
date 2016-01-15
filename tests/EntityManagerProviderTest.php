<?php

namespace Ray\DoctrineOrmModule;

use Doctrine\ORM\EntityManagerInterface;
use Ray\DoctrineOrmModule\Entity\FakeUser;

class EntityManagerProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testProvider()
    {
        $module = new EntityManagerProvider([['driver' => 'pdo_sqlite', 'memory' => true], [__DIR__ . '/Fake/Entity/']]);
        $instance = $module->get();
        $this->assertInstanceOf(EntityManagerInterface::class, $instance);
        $this->assertTrue($this->isEntityClassLoaded($instance, FakeUser::class));
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
