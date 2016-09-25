# Contribuciones

Este repositorio requiere mantenimiento. En relación a esto, hay dos tipos de cambios que haremos habitualmente y uno que se hará en dependencia de la necesidad (actualizaciones, etc):

- Corrección de bugs.
- Adición de nuevas funcionalidades. Aquí podemos distinguir dos cosas: funcionalidades básicas que sirven para cualquier proyecto (y que podrían ir dentro de BaseBundle), y funcionalidades que son interesantes pero que deberían ir aisladas en sus propios bundles (siempre dentro de src/Runroom) para poder incorporarlas sólo si es necesario.
- Adición de nuevas funcionalidades en la compilación de recursos. Básicamente hablamos de gulp, el cual ya tiene las funcionalidades básicas y necesarias para la visualización de la web. Por lo que no deberían añadirse funcionalidades específicas de un solo proyecto. Si se deberá hacer un mantenimiento de módulos de node, como actualizaciones o reemplazo de módulos que hayan quedado obsoletos.

En cualquier caso, es buena idea comentar las novedades con los developers y fronts para que estén al tanto de los últimos cambios y puedan incorporarlos a sus proyectos si es necesario.

Por último, cada nueva funcionalidad que se desee incorporar al arquetipo debería estar testeada al 100%.
