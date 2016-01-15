<?php
/**
 * This file is part of the Ray.DoctrineOrmModule package
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Ray\DoctrineOrmModule;

use Doctrine\ORM\EntityManagerInterface;
use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;
use Ray\DoctrineOrmModule\Exception\RollbackException;

class TransactionalInterceptor implements MethodInterceptor
{
    /**
     * {@inheritdoc}
     */
    public function invoke(MethodInvocation $invocation)
    {
        $object = $invocation->getThis();
        $ref = new \ReflectionProperty($object, "entityManager");
        $ref->setAccessible(true);
        $entityManager = $ref->getValue($object);
        /* @var $entityManager EntityManagerInterface */

        $entityManager->beginTransaction();
        try {
            $result = $invocation->proceed();
            $entityManager->commit();
            return $result;
        } catch (\Exception $e) {
            $entityManager->rollback();
            throw new RollbackException($e, 0, $e);
        }
    }
}
