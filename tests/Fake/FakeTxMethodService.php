<?php

namespace Ray\DoctrineOrmModule;

use Ray\DoctrineOrmModule\Annotation\Transactional;

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
