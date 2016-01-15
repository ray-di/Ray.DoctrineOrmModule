<?php

namespace Ray\DoctrineOrmModule;

use Ray\Di\AbstractModule;

class AppModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $module = new DoctrineOrmModule(['driver' => 'pdo_sqlite', 'memory' => true], [__DIR__ . '/Fake/Entity/']);
        $this->install($module);
    }
}
