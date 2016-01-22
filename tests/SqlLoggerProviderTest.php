<?php

namespace Ray\DoctrineOrmModule;

use Ray\DoctrineOrmModule\Logger\PsrSqlLogger;

class SqlLoggerProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testProvider()
    {
        $provider = new SqlLoggerProvider(new FakeLogger);
        $instance = $provider->get();

        $this->assertInstanceOf(PsrSqlLogger::class, $instance);
    }
}
