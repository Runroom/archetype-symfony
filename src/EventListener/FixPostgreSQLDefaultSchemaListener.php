<?php

declare(strict_types=1);

namespace App\EventListener;

use Doctrine\DBAL\Schema\PostgreSqlSchemaManager;
use Doctrine\ORM\Tools\Event\GenerateSchemaEventArgs;

final class FixPostgreSQLDefaultSchemaListener
{
    public function postGenerateSchema(GenerateSchemaEventArgs $args): void
    {
        $schemaManager = $args->getEntityManager()->getConnection()->createSchemaManager();

        if (!$schemaManager instanceof PostgreSqlSchemaManager) {
            return;
        }

        $schema = $args->getSchema();

        foreach ($schemaManager->getExistingSchemaSearchPaths() as $namespace) {
            if (!$schema->hasNamespace($namespace)) {
                $schema->createNamespace($namespace);
            }
        }
    }
}
