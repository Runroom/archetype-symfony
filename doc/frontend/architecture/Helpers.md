# Helpers

```
- extends
- embed
+ include
+ loops (* internos)
```

Los _helpers_, como su nombre lo indica, son ayudas que podemos tener en un proyecto para generar o reutilizar algún tipo de elemento que sea necesario a través del tag `{% macro %}` de Twig. Los macros, en otras palabras, son funciones que pueden recibir parámetros e incluso llamarse a si mismos.

Para incluir un macro recomendamos la siguiente sintaxis. Esta nos permitirá llamar solamente el macro que necesitamos sin necesidad de traer todo el macro como un objeto.

```twig
{% from 'helpers/macros.html.twig' import icon %}

{{ icon('arrow') }}
```

----

## Índice de contenido

- [Home](./Index.md)
- [Layouts](./Layouts.md)
- [Pages](./Pages.md)
- [Modules](./Modules.md)
- [Components](./Components.md)
- Helpers ↞
- [Otros directorios](./Others.md)
- [Especificaciones Drupal](./Drupal.md)
