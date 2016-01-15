<?php
/**
 * This file is part of the Ray.DoctrineOrmModule package
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Ray\DoctrineOrmModule;

use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;
use Ray\DoctrineOrmModule\Exception\RollbackException;
use Ray\DoctrineOrmModule\Inject\EntityManagerInject;

class TransactionalInterceptor implements MethodInterceptor
{
    use EntityManagerInject;

    /**
     * {@inheritdoc}
     */
    public function invoke(MethodInvocation $invocation)
    {
        $this->entityManager->beginTransaction();

        try {
            $result = $invocation->proceed();
            $this->entityManager->commit();
            return $result;
        } catch (\Exception $e) {
            $this->entityManager->rollback();
            throw new RollbackException($e, 0, $e);
        }
    }
}
