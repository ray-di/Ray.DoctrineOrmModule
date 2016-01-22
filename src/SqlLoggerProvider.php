<?php
/**
 * This file is part of the Ray.DoctrineOrmModule package
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Ray\DoctrineOrmModule;

use Doctrine\DBAL\Logging\SQLLogger;
use Psr\Log\LoggerInterface;
use Ray\Di\Di\Inject;
use Ray\Di\ProviderInterface;
use Ray\DoctrineOrmModule\Logger\PsrSqlLogger;

class SqlLoggerProvider implements ProviderInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Constructor.
     *
     * @param LoggerInterface $logger
     *
     * @Inject
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return SQLLogger
     */
    public function get()
    {
        return new PsrSqlLogger($this->logger);
    }
}
