<?php

namespace Ray\DoctrineOrmModule;

use Ray\Di\Injector;
use Ray\DoctrineOrmModule\Exception\RollbackException;

class TransactionalModuleTest extends \PHPUnit_Framework_TestCase
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

    public function testTransactional()
    {
        // Class with @Transactional
        {
            $instance = $this->injector->getInstance(FakeTxClassService::class);
            /* @var $instance FakeTxClassService */
            $this->assertTrue($instance->returnIsInTransaction());
        }
        // Method with @Transactional
        {
            $instance = $this->injector->getInstance(FakeTxMethodService::class);
            /* @var $instance FakeTxMethodService */
            $this->assertTrue($instance->returnIsInTransaction());
        }
    }

    public function testThrowRollbackException()
    {
        // Class with @Transactional
        {
            $instance = $this->injector->getInstance(FakeTxClassService::class);
            /* @var $instance FakeTxClassService */

            $this->setExpectedException(RollbackException::class);
            $instance->throwFakeException();
        }
        // Method with @Transactional
        {
            $instance = $this->injector->getInstance(FakeTxMethodService::class);
            /* @var $instance FakeTxMethodService */

            $this->setExpectedException(RollbackException::class);
            $instance->throwFakeException();
        }
    }

    public function testNotTransactional()
    {
        $instance = $this->injector->getInstance(FakeService::class);
        /* @var $instance FakeService */
        $this->assertFalse($instance->returnIsInTransaction());
    }

    public function testThrowNotRollbackException()
    {
        $instance = $this->injector->getInstance(FakeService::class);
        /* @var $instance FakeService */

        $this->setExpectedException(FakeException::class);
        $instance->throwFakeException();
    }
}
