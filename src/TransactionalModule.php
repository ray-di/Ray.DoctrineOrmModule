<?php
/**
 * This file is part of the Ray.DoctrineOrmModule package
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Ray\DoctrineOrmModule;

use Ray\Di\AbstractModule;
use Ray\DoctrineOrmModule\Annotation\Transactional;

class TransactionalModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        // Class annotated with @Transactional
        $this->bindInterceptor(
            $this->matcher->annotatedWith(Transactional::class),
            $this->matcher->any(),
            [TransactionalInterceptor::class]
        );

        // Method annotated with @Transactional
        $this->bindInterceptor(
            $this->matcher->any(),
            $this->matcher->annotatedWith(Transactional::class),
            [TransactionalInterceptor::class]
        );
    }
}
