<?php

namespace Ray\DoctrineOrmModule;

use Ray\Di\AbstractModule;

class FakeAppModule extends AbstractModule
{
    protected function configure()
    {
        $this->install(new EntityManagerModule(['driver' => 'pdo_sqlite', 'memory' => true], [dirname(__DIR__) . '/Fake/Entity/']));
        $this->install(new TransactionalModule);
    }
}
