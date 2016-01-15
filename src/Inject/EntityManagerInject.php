<?php
/**
 * This file is part of the Ray.DoctrineOrmModule package
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Ray\DoctrineOrmModule\Inject;

use Doctrine\ORM\EntityManagerInterface;
use Ray\Di\Di\Inject;

trait EntityManagerInject
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     *
     * @Inject
     */
    public function setEntityManager(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
