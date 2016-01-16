# Ray.DoctrineOrmModule

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/kawanamiyuu/Ray.DoctrineOrmModule/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/kawanamiyuu/Ray.DoctrineOrmModule/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/kawanamiyuu/Ray.DoctrineOrmModule/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/kawanamiyuu/Ray.DoctrineOrmModule/?branch=master)
[![Build Status](https://travis-ci.org/kawanamiyuu/Ray.DoctrineOrmModule.svg?branch=master)](https://travis-ci.org/kawanamiyuu/Ray.DoctrineOrmModule)

A [Doctrine ORM](https://github.com/doctrine/doctrine2) Module for [Ray.Di](https://github.com/ray-di/Ray.Di)

## Installation

### Composer install

```bash
$ composer require ray/doctrine-orm-module
```

### Module install

Learn more about [the database connection configuration](http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html).

```php
use Ray\Di\AbstractModule;
use Ray\DoctrineOrmModule\DoctrineOrmModule;

class AppModule extends AbstractModule
{
    const ENTITY_PATHS = ['/path/to/Entity/'];

    protected function configure()
    {
        $params = [
            'driver'   => 'pdo_pgsql',
            'user'     => 'username',
            'password' => 'password',
            'host'     => '127.0.0.1'
            'port'     => '5432',
            'dbname'   => 'myapp_db'
        ];

        $this->install(new DoctrineOrmModule($params, self::ENTITY_PATHS));

        //// OR ////

        $params = [
            'url' => 'postgresql://username:password@127.0.0.1:5432/myapp_db'
        ];

        $this->install(new DoctrineOrmModule($params, self::ENTITY_PATHS));
    }
}
```

### DI trait

 * [EntityManagerInject](https://github.com/kawanamiyuu/Ray.DoctrineOrmModule/blob/master/src/Inject/EntityManagerInject.php) for `Doctrine\ORM\EntityManagerInterface` interface

### Transaction management

Any method in the class marked with `@Transactional` is executed in a transaction.

```php
use Ray\DoctrineOrmModule\Annotation\Transactional;
use Ray\DoctrineOrmModule\Inject\EntityManagerInject;

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
use Ray\DoctrineOrmModule\Inject\EntityManagerInject;

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

## Demo

```bash
$ php docs/demo/run.php
// It works!
```

## Requirements

 * PHP 5.5+
 * hhvm
