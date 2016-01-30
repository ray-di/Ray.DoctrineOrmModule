<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\ORM\EntityManagerInterface;
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

$fake = (new Injector(new EntityManagerModule(['driver' => 'pdo_sqlite', 'memory' => true], ['/path/to/Entity/'])))->getInstance(Fake::class);
/* @var $fake Fake */
$works = ($fake->foo() instanceof EntityManagerInterface);
echo($works ? 'It works!' : 'It DOES NOT work!') . PHP_EOL;
