# Modules

```
+ extends
- embed
+ include
+ loops (* internos)
```

Los módulos (_modules_) a diferencia de los [_components_](./Components.md) son bloques de código "estáticos". Esto quiere decir que su contenido no se genera con las variables que se le pasan, si no, que se contruyen a partir de un contenido definido para ser incluídos en distintas páginas. En otras palabras, son una especie de _component_ que siempre se renderiza de la misma manera.

Al igual que los [_components_](./Components.md), no deberán hacer loop de si mismos.

Un ejemplo de _module_ puede ser un bloque por encima del footer destinado a la suscripción de una newsletter. Es un contenido que no necesita configuración. Pero puede aprovecharse de algún [_layout_](./Layouts.md) para estructurar su contenido.

----

## Índice de contenido

- [Home](./Index.md)
- [Layouts](./Layouts.md)
- [Pages](./Pages.md)
- Modules ↞
- [Components](./Components.md)
- [Helpers](./Helpers.md)
- [Otros directorios](./Others.md)
- [Especificaciones Drupal](./Drupal.md)
