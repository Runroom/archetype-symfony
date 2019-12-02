# Bugs: Webpack

## Terser Webpack Plugin
Actualmente, con las siguientes versiones de Webpack y Terser Pack:
```
{
  "name": "archetype-symfony",
  ...
  "devDependencies": {
    ...
    "terser-webpack-plugin": "2.2.1",
    "webpack": "4.41.2",
    "webpack-stream": "5.2.1"
  }
}
```

Se genera un error al intentar compilar 2 o más tareas utilizando la misma configuración. En nuestro caso, utilizamos la configuración para `gulpfile.babel.js/tasks/styles.base.js` y `gulpfile.babel.js/tasks/scripts.base.js`.

La solución ha sido separar las configuraciones y utilizar la correspondiente en cada tarea. Es probable que con la versión de Webpack 5, esto pueda cambiar. De todas maneras, es **importante tener en cuenta** que necesitamos añadir una nueva configuración de webpack para otra tarea que necesite de ella.
