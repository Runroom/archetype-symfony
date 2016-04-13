<?php

namespace Runroom\DemoBundle\Tests\Integration;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\Tools\SchemaTool;

abstract class DoctrineIntegrationTestBase extends \PHPUnit_Extensions_Database_TestCase {

    protected static $em;
    protected static $kernel;
    protected static $container;
    protected static $manager_registry;

    private $pdo = null;
    private $conn = null;

    abstract protected function getDataSetFile();

    public function getContainer()
    {
        return static::$container;
    }

    final protected function getConnection()
    {
        if ($this->conn === null) {
            if ($this->pdo == null) {
                $this->pdo = static::$em->getConnection()->getWrappedConnection();
            }
            $this->conn = $this->createDefaultDBConnection($this->pdo, ':memory:');
        }
        return $this->conn;
    }

    protected function getSetUpOperation()
    {
        return new \PHPUnit_Extensions_Database_Operation_Composite([
            \PHPUnit_Extensions_Database_Operation_Factory::INSERT()
        ]);
    }

    protected function getDataSet()
    {
        return $this->createFlatXMLDataSet($this->getDataSetFile());
    }

    static public function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        static::$kernel = new \AppKernel('test', true);
        static::$kernel->boot();
        static::$container = static::$kernel->getContainer();
        static::$manager_registry = static::$container->get('doctrine');
        static::$em = static::$container->get('doctrine')->getManager();

        $schemaTool = new SchemaTool(static::$em);
        $metadata = static::$em->getMetadataFactory()->getAllMetadata();
        $schemaTool->dropSchema($metadata);
        $schemaTool->createSchema($metadata);
    }

    protected function tearDown()
    {
        $purger = new ORMPurger(static::$em);
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_TRUNCATE);
        $purger->purge();
        parent::tearDown();
    }

    protected function setUp()
    {
        parent::setUp();
    }
}
