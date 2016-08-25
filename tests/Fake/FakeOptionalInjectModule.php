<?php

namespace Ray\DoctrineOrmModule;

use Ray\Di\AbstractModule;
use Ray\DoctrineOrmModule\Annotation\ProxyDir;

class FakeOptionalInjectModule extends AbstractModule
{
    protected function configure()
    {
        $this->bind()->annotatedWith(ProxyDir::class)->toInstance($_ENV['PROXY_DIR']);
        $this->install(new FakeSqlLoggerModule);
        $this->install(new FakeAppModule);
    }
}
