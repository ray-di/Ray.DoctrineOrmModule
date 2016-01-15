<?php

namespace Ray\DoctrineOrmModule;

use Ray\DoctrineOrmModule\Annotation\Transactional;
use Ray\DoctrineOrmModule\Inject\EntityManagerInject;

/**
 * @Transactional
 */
class FakeTxClassService implements FakeServiceInterface
{
    use EntityManagerInject;

    public function returnIsInTransaction()
    {
        return $this->entityManager->getConnection()->isTransactionActive();
    }

    public function throwFakeException()
    {
        throw new FakeException();
    }
}
