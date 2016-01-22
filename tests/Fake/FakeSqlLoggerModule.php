<?php

namespace Ray\DoctrineOrmModule;

use Psr\Log\LoggerInterface;
use Ray\Di\AbstractModule;

class FakeSqlLoggerModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->bind(LoggerInterface::class)->toInstance(new FakeLogger);
        $this->install(new SqlLoggerModule);
    }
}
