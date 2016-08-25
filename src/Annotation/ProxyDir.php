<?php

namespace Ray\DoctrineOrmModule\Annotation;

use Ray\Di\Di\Qualifier;

/**
 * @Annotation
 * @Target("METHOD")
 * @Qualifier
 */
final class ProxyDir
{
    public $value;
}
