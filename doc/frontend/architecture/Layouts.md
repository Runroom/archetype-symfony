# Layouts

```
+ extends
- embed
+ include
- loops
```

Los _layouts_ son estructuras generales de código HTML que nos ayudan a reutilizarlas en distintas páginas (_pages_) o módulos (_modules_).

Un _layout_ puede tener una hoja de estilo asociado (archivo Scss) para optimizar la percepción de velocidad de carga o CRP (_Critical Rendering Path_). Esto nos permitirá tener estilos predeterminados ya configurados y que nos permita reducir la cantidad de archivos CRP, ya que los agrupamos dentro de un mismo _layout_.

Tendremos dos tipos de _layouts_ que se podrán utilizar en situaciones específicas.

## Page layouts

Son los _layouts_ que utilizamos hasta ahora, para la creación de páginas. Siempre deberán existir dos _layouts_ que serán la base de nuestras páginas del proyecto:

- **base.html.twig** Es el _layout_ que contiene el HTML básico para generar el resto de _layouts_. Solo los layouts de páginas pueden — o deben — extender de este _layout_.
- **default.html.twig** Es nuestro _layout_ base para todas lás páginas. Este incluirá los componentes y secciones necesarias para la mayoría de páginas de nuestro proyecto.

A partir de aquí, se podrán generar otros _layouts_ para páginas que requieran una estructura diferente. Por ejemplo, podríamos tener _layouts_ para páginas con sidebar, páginas estáticas con una cabecera o footer distinto, etc.

Al extender de estos nuevos tipos de _layouts_ recomendamos hacerlo de la siguiente manera:

```twig
{% extends ['layouts/statics.html.twig', 'layouts/default.html.twig'] %}
```

De esta manera, tendremos un fallback en caso de que se elimine uno de estos _layouts_ sin contemplar el uso que se le esté dando.


## Section layouts

También podrán existir _layouts_ de secciones. Estos nos permitirán reutilizar secciones de código HTML que se repitan en el proyecto. Estos _layouts_, a diferencia de los de páginas, **no deberán extender de otro layout**, solo contendrán código HTML con bloques definidos para su utilización. Por ejemplo, podríamos reutilizar una sección con un bloque lateral (30%) y otro de contenido (70%) que se comporta de una manera definida en distintos dispositivos. En vez de repetir el mismo código, podemos crear un _layout_ `section-aside.html.twig`.

Dentro de una página podríamos utilizarlos gracias al tag de Twig `{% embed %}` que nos permitiría reutilizarlo dentro de un _layout_ de página sin tener que crear archivos por cada sección que necesitemos incluir.

También se pueden utilizar dentro de los _modules_ quienes podrán extender estos _layouts_ para aprovechar la estructura definida.

----

## Índice de contenido

- [Home](./Index.md)
- Layouts ↞
- [Pages](./Pages.md)
- [Modules](./Modules.md)
- [Components](./Components.md)
- [Helpers](./Helpers.md)
- [Otros directorios](./Others.md)
- [Especificaciones Drupal](./Drupal.md)
