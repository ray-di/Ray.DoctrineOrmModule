<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use Ray\DoctrineOrmModule\EntityManagerModule;
use Ray\DoctrineOrmModule\Inject\EntityManagerInject;

$loader = require dirname(dirname(__DIR__)) . '/vendor/autoload.php';
/* @var $loader \Composer\Autoload\ClassLoader */
AnnotationRegistry::registerLoader([$loader, 'loadClass']);

class Fake
{
    use EntityManagerInject;

    public function foo()
    {
        return $this->entityManager;
    }
}

class AppModule extends AbstractModule
{
    protected function configure()
    {
        $this->install(new EntityManagerModule(['driver' => 'pdo_sqlite', 'memory' => true], ['/path/to/Entity/']));
    }
}

$fake = (new Injector(new AppModule))->getInstance(Fake::class);
/* @var $fake Fake */
$works = ($fake->foo() instanceof EntityManagerInterface);
echo($works ? 'It works!' : 'It DOES NOT work!') . PHP_EOL;
