<?php

namespace Tests\Runroom\BaseBundle\Integration;

use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\DbUnit\Database\DefaultConnection;
use PHPUnit\DbUnit\TestCase;

abstract class DoctrineIntegrationTestBase extends TestCase
{
    protected static $kernel;
    protected static $container;
    protected static $connection;
    protected static $entityManager;

    public static function setUpBeforeClass()
    {
        if (!is_null(static::$kernel)) {
            return;
        }

        static::$kernel = new \AppKernel('test', true);
        static::$kernel->boot();

        static::$container = static::$kernel->getContainer();
        static::$connection = new DefaultConnection(
            static::$container->get('doctrine.dbal.default_connection')->getWrappedConnection(),
            ':memory:'
        );

        static::$entityManager = static::$container->get('doctrine.orm.entity_manager');
        $schema_tool = new SchemaTool(static::$entityManager);
        $schema_tool->createSchema(static::$entityManager->getMetadataFactory()->getAllMetadata());
    }

    final protected function getContainer()
    {
        return static::$container;
    }

    final protected function getConnection()
    {
        return static::$connection;
    }

    final protected function getDataSet()
    {
        return $this->createFlatXMLDataSet($this->getDataSetFile());
    }

    abstract protected function getDataSetFile();
}
