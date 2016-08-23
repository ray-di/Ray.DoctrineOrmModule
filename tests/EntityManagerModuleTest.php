<?php

namespace Ray\DoctrineOrmModule;

use Doctrine\DBAL\Logging\SQLLogger;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Proxy\ProxyFactory;
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

        $config = $instance->getConfiguration();
            
        $this->assertNull($config->getSQLLogger());
        $this->assertEquals(sys_get_temp_dir(), $config->getProxyDir()); // proxy dir is set, but is never used
        $this->assertEquals(ProxyFactory::AUTOGENERATE_EVAL, $config->getAutoGenerateProxyClasses());
    }

    public function testCompile()
    {
        (new DiCompiler(new FakeAppModule, $_ENV['TMP_DIR']))->compile();
    }

    public function testModuleWithOptionalInject()
    {
        $instance = (new Injector(new FakeOptionalInjectModule, $_ENV['TMP_DIR']))->getInstance(EntityManagerInterface::class);
        /* @var $instance EntityManagerInterface */

        $this->assertInstanceOf(EntityManagerInterface::class, $instance);
        $this->assertTrue($this->isEntityClassLoaded($instance, FakeUser::class));

        $config = $instance->getConfiguration();

        $this->assertInstanceOf(SQLLogger::class, $config->getSQLLogger());
        $this->assertEquals($_ENV['TMP_DIR'] . '/proxy', $config->getProxyDir());
        $this->assertEquals(ProxyFactory::AUTOGENERATE_FILE_NOT_EXISTS, $config->getAutoGenerateProxyClasses());
    }

    public function testCompileWithOptionalInject()
    {
        (new DiCompiler(new FakeOptionalInjectModule, $_ENV['TMP_DIR']))->compile();
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
