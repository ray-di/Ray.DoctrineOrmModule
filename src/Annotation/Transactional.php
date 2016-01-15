<?php
/**
 * This file is part of the Ray.DoctrineOrmModule package
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Ray\DoctrineOrmModule\Annotation;

use Ray\Di\Di\Qualifier;

/**
 * @Annotation
 * @Target({"CLASS","METHOD"})
 * @Qualifier
 */
final class Transactional
{
}
