# Ray.DoctrineOrmModule

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/kawanamiyuu/Ray.DoctrineOrmModule/badges/quality-score.png?b=1.x)](https://scrutinizer-ci.com/g/kawanamiyuu/Ray.DoctrineOrmModule/?branch=1.x)
[![Code Coverage](https://scrutinizer-ci.com/g/kawanamiyuu/Ray.DoctrineOrmModule/badges/coverage.png?b=1.x)](https://scrutinizer-ci.com/g/kawanamiyuu/Ray.DoctrineOrmModule/?branch=1.x)
[![Build Status](https://travis-ci.org/kawanamiyuu/Ray.DoctrineOrmModule.svg?branch=1.x)](https://travis-ci.org/kawanamiyuu/Ray.DoctrineOrmModule)
[![Packagist](https://img.shields.io/packagist/v/ray/doctrine-orm-module.svg?maxAge=3600)](https://packagist.org/packages/ray/doctrine-orm-module)
[![Packagist](https://img.shields.io/packagist/l/ray/doctrine-orm-module.svg?maxAge=3600)](https://github.com/kawanamiyuu/Ray.DoctrineOrmModule/blob/1.x/LICENSE)

A [Doctrine ORM](https://github.com/doctrine/doctrine2) Module for [Ray.Di](https://github.com/ray-di/Ray.Di)

## Installation

### Composer install

```bash
$ composer require ray/doctrine-orm-module
```

### Module install

```php
use Ray\Di\AbstractModule;
use Ray\DoctrineOrmModule\EntityManagerModule;

class AppModule extends AbstractModule
{
    protected function configure()
    {
        $entityDir = '/path/to/Entity/';

        $params = [
            'driver'   => 'pdo_pgsql',
            'user'     => 'username',
            'password' => 'password',
            'host'     => '127.0.0.1'
            'port'     => '5432',
            'dbname'   => 'myapp_db'
        ];

        $this->install(new EntityManagerModule($params, $entityDir));

        //// OR ////

        $params = [
            'url' => 'postgresql://username:password@127.0.0.1:5432/myapp_db'
        ];

        $this->install(new EntityManagerModule($params, $entityDir));
    }
}
```

Learn more about [the database connection configuration](http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html).

## DI trait

 * [EntityManagerInject](https://github.com/kawanamiyuu/Ray.DoctrineOrmModule/blob/1.x/src/EntityManagerInject.php) for `Doctrine\ORM\EntityManagerInterface` interface

## Transaction management

First, install `TransactionalModule`.

```php
use Ray\Di\AbstractModule;
use Ray\DoctrineOrmModule\EntityManagerModule;
use Ray\DoctrineOrmModule\TransactionalModule;

class AppModule extends AbstractModule
{
    protected function configure()
    {
        $this->install(new EntityManagerModule($params, $entityDir));

        $this->install(new TransactionalModule); // <--
    }
}
```

Any method in the class marked with `@Transactional` is executed in a transaction.

```php
use Ray\DoctrineOrmModule\Annotation\Transactional;
use Ray\DoctrineOrmModule\EntityManagerInject;

/**
 * @Transactional
 */
class UserService
{
    use EntityManagerInject;

    public function foo()
    {
        // transaction is active
        $this->entityManager->...;
    }

    public function bar()
    {
        // transaction is active
        $this->entityManager->...;
    }
}
```

The method marked with `@Transactional` is executed in a transaction.

```php
use Ray\DoctrineOrmModule\Annotation\Transactional;
use Ray\DoctrineOrmModule\EntityManagerInject;

class UserService
{
    use EntityManagerInject;

    /**
     * @Transactional
     */
    public function foo()
    {
        // transaction is active
        $this->entityManager->...;
    }

    public function bar()
    {
        // transaction is not active
        $this->entityManager->...;
    }
}
```

## Generating Proxy classes (for production)

Proxy classes improve the performance in a production environment.
If you bind `ProxyDir`, proxy classes are automatically generated into the directory when they are used the first time.

```php
use Ray\Di\AbstractModule;
use Ray\DoctrineOrmModule\Annotation\ProxyDir;
use Ray\DoctrineOrmModule\EntityManagerModule;

class AppModule extends AbstractModule
{
    protected function configure()
    {
        $this->bind()->annotatedWith(ProxyDir::class)->toInstance('/path/to/proxy'); // <--

        $this->install(new EntityManagerModule($params, $entityDir));
    }
}
```

Learn more about [the Proxy Object](http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/advanced-configuration.html#proxy-objects).

## Logging queries

If you want to log queries, you additionally need to bind `Psr\Log\LoggerInterface` and install `SqlLoggerModule`.

```php
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Ray\Di\AbstractModule;
use Ray\DoctrineOrmModule\EntityManagerModule;
use Ray\DoctrineOrmModule\SqlLoggerModule;
use Ray\DoctrineOrmModule\TransactionalModule;

class AppModule extends AbstractModule
{
    protected function configure()
    {
        $this->install(new EntityManagerModule($params, $entityDir));
        $this->install(new TransactionalModule);

        $this->bind(LoggerInterface::class)->toInstance(new Logger('myapp')); // <--
        $this->install(new SqlLoggerModule); // <--
    }
}
```

## Demo

```bash
$ php docs/demo/run.php
// It works!
```

## Requirements

 * PHP 5.6+
 * hhvm
