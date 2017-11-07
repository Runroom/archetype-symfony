# Configuracion

El bundle Basebundle de la carpeta Runroom acepta configuración:

```
runroom_base:
    page_view_model: 'Runroom\BaseBundle\ViewModel\PageViewModel'
```

Con ese parametro se puede modificar el view model que se usa para renderizar
las páginas.

El único requisito es que debe extender la interfaz `Runroom\BaseBundle\ViewModel\PageViewModelInterface`
