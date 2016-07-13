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

class TransactionalInterceptor implements MethodInterceptor
{
    use EntityManagerInject;

    /**
     * {@inheritdoc}
     */
    public function invoke(MethodInvocation $invocation)
    {
        $result = null;

        try {
            $this->entityManager->transactional(function () use ($invocation, &$result) {
                $result = $invocation->proceed();
            });
        } catch (\Exception $e) {
            throw new RollbackException($e, 0, $e);
        }

        return $result;
    }
}
