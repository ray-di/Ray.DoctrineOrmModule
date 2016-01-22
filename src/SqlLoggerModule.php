<?php
/**
 * This file is part of the Ray.DoctrineOrmModule package
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Ray\DoctrineOrmModule;

use Doctrine\DBAL\Logging\SQLLogger;
use Ray\Di\AbstractModule;
use Ray\Di\Scope;

class SqlLoggerModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->bind(SQLLogger::class)->toProvider(SqlLoggerProvider::class)->in(Scope::SINGLETON);
    }
}
