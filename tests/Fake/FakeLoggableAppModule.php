<?php

namespace Ray\DoctrineOrmModule;

use Ray\Di\AbstractModule;

class FakeLoggableAppModule extends AbstractModule
{
    protected function configure()
    {
        $this->install(new FakeAppModule);
        $this->install(new FakeSqlLoggerModule);
    }
}
