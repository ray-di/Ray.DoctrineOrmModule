<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Ray\Di\Injector;
use Ray\DoctrineOrmModule\DoctrineOrmModule;
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

/* @var $fake Fake */
$fake = (new Injector(new DoctrineOrmModule(['driver' => 'pdo_sqlite', 'memory' => true], ['/path/to/entity/'])))->getInstance(Fake::class);

$works = ($fake->foo() instanceof EntityManagerInterface);
echo($works ? 'It works!' : 'It DOES NOT work!') . PHP_EOL;
