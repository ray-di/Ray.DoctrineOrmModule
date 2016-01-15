<?php

namespace Ray\DoctrineOrmModule;

use Ray\Aop\Arguments;
use Ray\Aop\ReflectiveMethodInvocation;
use Ray\Di\Injector;
use Ray\DoctrineOrmModule\Exception\RollbackException;

class TransactionalInterceptorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Injector
     */
    private $injector;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        parent::setUp();
        $this->injector = new Injector(new AppModule, $_ENV['TMP_DIR']);
    }

    public function testTxCommit()
    {
        $object = $this->injector->getInstance(FakeService::class);
        $interceptor = $this->injector->getInstance(TransactionalInterceptor::class);
        $invocation = new ReflectiveMethodInvocation(
            $object,
            new \ReflectionMethod($object, 'returnIsInTransaction'),
            new Arguments([]),
            [$interceptor]
        );

        $wasInTransaction = $invocation->proceed();
        $this->assertTrue($wasInTransaction);
    }

    public function testTxRollback()
    {
        $object = $this->injector->getInstance(FakeService::class);
        $interceptor = $this->injector->getInstance(TransactionalInterceptor::class);
        $invocation = new ReflectiveMethodInvocation(
            $object,
            new \ReflectionMethod($object, 'throwFakeException'),
            new Arguments([]),
            [$interceptor]
        );

        $this->setExpectedException(RollbackException::class);
        $invocation->proceed();
    }
}
