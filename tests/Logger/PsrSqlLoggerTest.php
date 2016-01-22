<?php

namespace Ray\DoctrineOrmModule\Logger;

use Ray\DoctrineOrmModule\FakeLogger;

class PsrSqlLoggerTest extends \PHPUnit_Framework_TestCase
{
    public function testLogger()
    {
        $logger = new FakeLogger;
        $sqlLogger = new PsrSqlLogger($logger);
        $sqlLogger->startQuery('query', ['p1', 'p2'], ['t1', 't2']);
        $sqlLogger->stopQuery();

        $this->assertCount(2, $logger->logs);

        $this->assertEquals('query', $logger->logs[0]['message']);
        $this->assertEquals(['p1', 'p2'], $logger->logs[0]['context']['params']);
        $this->assertEquals(['t1', 't2'], $logger->logs[0]['context']['types']);

        $this->assertRegExp('/^query execution time: [0-9]+s$/', $logger->logs[1]['message']);
        $this->assertNotContains('params', $logger->logs[1]['context']);
        $this->assertNotContains('types', $logger->logs[1]['context']);
    }
}
