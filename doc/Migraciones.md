# Migraciones

Como sistema de migraciones de base de datos se utiliza el bundle
[DoctrineMigrationsBundle](http://symfony.com/doc/current/bundles/DoctrineMigrationsBundle/index.html)


Cuando se añadan entidades o se modifiquen propiedades de las mismas se genera
una migración ejecutando:

    php app/console doctrine:migrations:diff

Esto creará una clase php en app/DoctrineMigrations que permite tanto avanzar
como retroceder en las diferentes versiones de nuestra base de datos.


Para actualizar la base de datos a la última versión se ejecuta:

    php app/console doctrine:migrations:migrate

Para retroceder a una versión anterior se ejecuta:

    php app/console doctrine:migrations:migrate prev

Para avanzar a una versión posterior se ejecuta:

    php app/console doctrine:migrations:migrate prev

Por último, para migrar a una versión en concreto se ejecuta:

    php app/console doctrine:migrations:migrate <timestamp>

Donde <timestamp> es el timestamp de la versión, ej: 20100621140655
