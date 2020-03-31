# Migrations

The Archetype uses the [DoctrineMigrationsBundle](http://symfony.com/doc/current/bundles/DoctrineMigrationsBundle/index.html)
for the database migrations.

When a new entity is added or modified a new migration can be created 
from the command line:

    console doctrine:migrations:diff

This command will create a new class in the src/Migrations folder
which you can use to run your migration back and forth.

To update your database to the latest available version use the command:

    console doctrine:migrations:migrate

To undo the last migration run:

    console doctrine:migrations:migrate prev

To update your database to the next migration:

    console doctrine:migrations:migrate next

You can also migrate to an specific version:

    console doctrine:migrations:migrate <timestamp>

Where <timestamp> is the version timestamp. ex: 20100621140655
