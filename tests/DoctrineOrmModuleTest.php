<?php

namespace Ray\DoctrineOrmModule;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Ray\Compiler\DiCompiler;
use Ray\Di\Injector;

class DoctrineOrmModuleTest extends \PHPUnit_Framework_TestCase
{
    public function testModule()
    {
        $module = new DoctrineOrmModule(['driver' => 'pdo_sqlite', 'memory' => true], [__DIR__ . '/Fake/Entity/']);
        $instance = (new Injector($module, $_ENV['TMP_DIR']))->getInstance(EntityManagerInterface::class);
        /* @var $instance EntityManagerInterface */
        $this->assertInstanceOf(EntityManagerInterface::class, $instance);

        $allMetadata = $instance->getMetadataFactory()->getAllMetadata();
        /* @var $allMetadata ClassMetadata[] */
        $this->assertCount(1, $allMetadata);
        $this->assertEquals('Ray\DoctrineOrmModule\Entity\FakeUser', $allMetadata[0]->getName());
    }

    public function testCompile()
    {
        $module = new DoctrineOrmModule(['driver' => 'pdo_sqlite', 'memory' => true], []);
        (new DiCompiler($module, $_ENV['TMP_DIR']))->compile();
    }
}
