<?php
/**
 * This file is part of the Ray.DoctrineOrmModule package
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Ray\DoctrineOrmModule\Logger;

use Doctrine\DBAL\Logging\SQLLogger;
use Psr\Log\LoggerInterface;

class PsrSqlLogger implements SQLLogger
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var float
     */
    private $start;

    /**
     * constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function startQuery($sql, array $params = null, array $types = null)
    {
        $this->logger->debug($sql, ['params' => $params, 'types' => $types]);
        $this->start = microtime(true);
    }

    /**
     * [@inheritdoc}
     */
    public function stopQuery()
    {
        $time = round(microtime(true) - $this->start, 3);
        $this->logger->debug('query execution time: ' . $time . 's');
    }
}
