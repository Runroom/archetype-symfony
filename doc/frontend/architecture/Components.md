# Components

```
- extends
- embed
+ include
+ loops (* internos)
```

Los componentes (_components_) son bloques dinámicos que se podrán reutilizar en [_layouts_](./Layouts.md), [_pages_](./Pages.md), [_modules_](./Modules.md) e incluso en un mismo _component_. Estos recibirán variables, si es necesario, para construir su contenido.

Los _components_ tienen una serie de restricciones que debemos mantener para mantener nuestro código y estructura lo más limpio y simple posible.

- No deben extender de un _layout_
- Tampoco podrán tener `embeds`
- Podrán tener loops dentro del código, pero nunca deberán hacer loop de si mismos
- Pueden incluir otros _components_
- Deberán tener su propio archivo de estilos asociado
- No deberán ser una lista de ningún tipo, es el archivo que los llama quién definirá dónde y cómo se renderizan
- No deberán tener lógica que depende de algo externo a si mismo, excepto traducciones para su valor predeterminado

----

## Índice de contenido

- [Home](./Index.md)
- [Layouts](./Layouts.md)
- [Pages](./Pages.md)
- [Modules](./Modules.md)
- Components ↞
- [Helpers](./Helpers.md)
- [Otros directorios](./Others.md)
- [Especificaciones Drupal](./Drupal.md)
