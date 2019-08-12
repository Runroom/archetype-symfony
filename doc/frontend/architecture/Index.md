# Frontend Architecture

La estructura planteada nos permitirá mantener una mayor consisencia en los proyectos y facilitará la labor de traspaso de conocimiento.

Seguiremos trabajando modularmente (Atomic), pero simplificando la idea de átomos, moléculas y organismos a **componentes**. La estructura planteada tiene una jerarquía marcada que nos ayudará a reducir la generación de archivos necesarios y la unificación de componentes reducirá la ambiguedad de dichos componentes.

Nos centraremos más en estructuras genéricas o _layouts_ que nos ayudarán a simplificar y unificar la estructura de nuestro proyecto.

La organización planteada es la siguiente:

```
.
└── templates
    ├── components
    ├── layouts
    │   ├── base.html.twig
    │   └── default.html.twig
    ├── modules
    ├── pages
    └── helpers (*optional)
```

----

## Índice de contenido

- Home ↞
- [Layouts](./Layouts.md)
- [Pages](./Pages.md)
- [Modules](./Modules.md)
- [Components](./Components.md)
- [Helpers](./Helpers.md)
- [Otros directorios](./Others.md)
- [Especificaciones Drupal](./Drupal.md)
