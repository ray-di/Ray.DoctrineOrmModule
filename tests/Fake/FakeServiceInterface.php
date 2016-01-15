<?php

namespace Ray\DoctrineOrmModule;

interface FakeServiceInterface
{
    public function returnIsInTransaction();

    public function throwFakeException();
}
