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
     * @var string
     */
    private $sql;

    /**
     * @var array
     */
    private $params;

    /**
     * @var array
     */
    private $types;

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
        $sql = trim($sql, '"');
        $params = $params ?: [];
        $types = $types ?: [];

        $this->logger->debug('start  query', [
            'sql' => $sql,
            'params' => $params,
            'types' => $types
        ]);

        $this->sql = $sql;
        $this->params = $params;
        $this->types = $types;

        $this->start = microtime(true);
    }

    /**
     * [@inheritdoc}
     */
    public function stopQuery()
    {
        $time = round(microtime(true) - $this->start, 3);

        $this->logger->debug('finish query', [
            'sql' => $this->sql,
            'params' => $this->params,
            'types' => $this->types,
            'time' => $time
        ]);
    }
}
