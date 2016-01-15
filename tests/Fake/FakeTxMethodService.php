<?php

namespace Ray\DoctrineOrmModule;

use Ray\DoctrineOrmModule\Annotation\Transactional;
use Ray\DoctrineOrmModule\Inject\EntityManagerInject;

class FakeTxMethodService implements FakeServiceInterface
{
    use EntityManagerInject;

    /**
     * @Transactional
     */
    public function returnIsInTransaction()
    {
        return $this->entityManager->getConnection()->isTransactionActive();
    }

    /**
     * @Transactional
     */
    public function throwFakeException()
    {
        throw new FakeException();
    }
}
