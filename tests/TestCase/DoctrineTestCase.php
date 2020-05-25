<?php

namespace Tests\TestCase;

use App\Kernel;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

abstract class DoctrineTestCase extends TestCase
{
    protected static $kernel;
    protected static $loader;
    protected static $container;
    protected static $entityManager;
    protected static $connection;
    protected static $parameterBag;

    public static function setUpBeforeClass(): void
    {
        if (static::$kernel !== null) {
            return;
        }

        static::$kernel = new Kernel('test', false);
        static::$kernel->boot();

        static::$container = static::$kernel->getContainer()->get('test.service_container');
        static::$entityManager = static::$container->get(EntityManagerInterface::class);
        static::$loader = static::$container->get('fidry_alice_data_fixtures.loader.doctrine');
        static::$connection = static::$container->get(ManagerRegistry::class)->getConnection();
        static::$parameterBag = static::$container->getParameterBag();

        static::$container->get(RequestStack::class)->push(new Request());

        $schemaTool = new SchemaTool(static::$entityManager);
        $schemaTool->createSchema(static::$entityManager->getMetadataFactory()->getAllMetadata());
    }

    protected function setUp(): void
    {
        static::$connection->beginTransaction();
        static::$loader->load($this->processDataFixtures(), static::$parameterBag->all());
        static::$entityManager->clear();
    }

    protected function tearDown(): void
    {
        static::$connection->rollBack();
    }

    protected function processDataFixtures(): array
    {
        return array_map(function ($value) {
            $testClass = new \ReflectionClass(static::class);

            return \dirname($testClass->getFileName(), 2) . '/Fixtures/' . $value;
        }, $this->getDataFixtures());
    }

    abstract protected function getDataFixtures(): array;
}
