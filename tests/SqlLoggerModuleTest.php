<?php

namespace Ray\DoctrineOrmModule;

use Doctrine\DBAL\Logging\SQLLogger;
use Ray\Compiler\DiCompiler;
use Ray\Di\Injector;

class SqlLoggerModuleTest extends \PHPUnit_Framework_TestCase
{
    public function testModule()
    {
        $injector = new Injector(new FakeSqlLoggerModule, $_ENV['TMP_DIR']);
        $instance = $injector->getInstance(SQLLogger::class);
        $this->assertInstanceOf(SQLLogger::class, $instance);
    }

    public function testCompile()
    {
        (new DiCompiler(new FakeSqlLoggerModule, $_ENV['TMP_DIR']))->compile();
    }
}
