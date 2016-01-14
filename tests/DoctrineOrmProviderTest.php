<?php

namespace Ray\DoctrineOrmModule;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;

class DoctrineOrmProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testProvider()
    {
        $module = new DoctrineOrmProvider([['driver' => 'pdo_sqlite', 'memory' => true], [__DIR__ . '/Fake/Entity/']]);
        $instance = $module->get();
        $this->assertInstanceOf(EntityManagerInterface::class, $instance);

        $allMetadata = $instance->getMetadataFactory()->getAllMetadata();
        /* @var $allMetadata ClassMetadata[] */
        $this->assertCount(1, $allMetadata);
        $this->assertEquals('Ray\DoctrineOrmModule\Entity\FakeUser', $allMetadata[0]->getName());
    }
}
