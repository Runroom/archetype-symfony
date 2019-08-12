# Especificaciones Drupal

## Estructura de directorios
La mayor diferencia con otro CMS o Framework se basa en la jerarquía de archivos que propone Drupal para la creación de sus páginas, módulos, nodos, etc.

Añadiremos un directorio `overrides` al mismo nivel que nuestros `templates` planteado en la estructura principal en la [Home](./Index.md). Estos directorios estarán dentro del `theme` definido para nuestro proyecto.

```
.
└── themes
    └── my-theme
        ├── ...
        ├── overrides
        │   └── ...
        └── templates
            └── ...
```

El directorio de `overrides` deberá contener la misma estructura de directorios y archivos del tema principal del que extiende. De esta manera, será más fácil encontrar los archivos relacionados. En estos archivos debríamos encontrar solamente `includes` o elementos básicos HTML (listas) o `loops`. No deberíamos encontrat mayor lógica o elementos dentro de estos archivos.

Este directorio nos permitirá seguir la nomenclatura planteada por Drupal e incluirán los archivos que nosotros creemos dentro de `templates` para mantener nuestra lógica en la arquitectura y minimizar la dependencia del backend.

## Nombre de archivos

Los nombres de los archivos dentro de `templates` deberán empezar por _underscore_ (`_`) para evitar sobreescribir casualmente los archivos definidos por Drupal. Esto es debido a que Drupal busca cualquier archivo Twig dentro del directorio del `theme` y sobreescribe los del `theme` base o del `core` de Drupal.

Por ejemplo, Drupal utiliza un archivo llamado `html.html.twig` para renderizar la base de nuestro HTML. La estructura que deberíamos tener sería la siguiente:

```
.
└── themes
    └── my-theme
        ├── overrides
        │   ├── layouts
        │   │   ├── html.html.twig
        │   │   └── ...
        │   └── ...
        └── templates
            ├── layouts
            │   ├── _base.html.twig
            │   └── ...
            └── ...
```

En este caso, nuestro _override_ `html.html.twig` extenderá de nuestro archivo `_base.html.twig`

``` twig
{# html.html.twig #}
{% extends directory ~ '/templates/layouts/_base.html.twig' %}
```

``` twig
{# _base.html.twig #}
<!DOCTYPE html>
<html {{ html_attributes.addClass('no-js') }}>
    <head>
        ...
    </head>
    <body>
        ...
        {% block body %}{% endblock %}
    </body>
</html>
```

Siempre que sobre escribamos un archivo de Drupal deberemos tener en cuenta **cuándo es necesario utilizar `include` y cuándo `extends`**. Para ellos solo es necesario hacer una pregunta:

#### El template que estoy añadiendo, tiene bloques o no?
Si la respuesta es si, utilizamos `extends`, de lo contrario **no podremos hacer uso de los bloques de ese _template_**. Para todo lo demás, utilizar `include`.

## Restructuración de componentes

Hay que tener en mente que la maquetación desarrollada en `templates` puede no ser la final. Siempre dependeremos de la manera como Drupal renderiza los elementos y necesitamos utilizar sus funciones y lógica, de lo contrario, el trabajo puede ser más tedioso e irse del scope definido.

Si mantenemos la lógica de esta estrucuta y las específicaciones de cómo crear componentes flexibles, el refactor de los componentes será mínimo.

## Estructura interna de Drupal

Drupal trabaja con distintos tipos de elementos dentro de su estructura, pero dentro de los que más utilizaremos son los `layouts`, `nodes` y `views`.

### Layouts

Los `layouts` son los que hemos trabajado en la sección de [_layouts_](./Layouts.md).

### Nodes

Los `nodes` son similares a nuestros [_components_](./Components.md). Drupal utiliza funciones específicas para renderizarlos dentro de una página, ya que estos se pueden añadir en una página o vista desde backoffice. Por lo tanto, si mantenemos elementos flexibles, que no dependen del contenedor, no tendremos que modificarlos.

### Views

Las `views` podemos entenderla mejor si las comparamos con nuestros _layouts_ de módulos, los cuales podemos utilizar como `embeds` en nuestras páginas. Pero, este `embed` lo hace Drupal desde su lógica interna, por lo que tendremos que trabajamrlos por separado.

En dependencia del diseño, podemos añadir HTML simple dentro de esto archivos (ya que solo serán contenedores) que estarán dentro del directorio de `overrides` o en caso sea necesario, pueden extender de un _layout_ específico para aprovechar la estructura. Sea cual sea el caso, deberemos mantener la lógica de renderizar los elementos internos (`nodes`) para no entrar en conflicto con la lógica establecida por Drupal.

----

## Índice de contenido

- [Home](./Index.md)
- [Layouts](./Layouts.md)
- [Pages](./Pages.md)
- [Modules](./Modules.md)
- [Components](./Components.md)
- [Helpers](./Helpers.md)
- [Otros directorios](./Others.md)
- Especificaciones Drupal ↞
