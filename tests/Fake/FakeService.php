<?php

namespace Ray\DoctrineOrmModule;

use Ray\DoctrineOrmModule\Inject\EntityManagerInject;

class FakeService implements FakeServiceInterface
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
