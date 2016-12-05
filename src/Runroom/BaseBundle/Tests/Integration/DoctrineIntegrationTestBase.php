<?php

namespace Runroom\BaseBundle\Tests\Integration;

use Doctrine\ORM\Tools\SchemaTool;

abstract class DoctrineIntegrationTestBase extends \PHPUnit_Extensions_Database_TestCase
{
    protected static $container;
    protected static $connection;

    public static function setUpBeforeClass()
    {
        $kernel = new \AppKernel('test', true);
        $kernel->boot();

        static::$container = $kernel->getContainer();
        static::$connection = new \PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection(
            static::$container->get('doctrine.dbal.default_connection')->getWrappedConnection(),
            ':memory:'
        );

        $entity_manager = static::$container->get('doctrine.orm.entity_manager');
        $schema_tool = new SchemaTool($entity_manager);
        $schema_tool->createSchema($entity_manager->getMetadataFactory()->getAllMetadata());
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
