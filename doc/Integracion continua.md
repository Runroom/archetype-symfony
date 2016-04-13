# Integración continua

Todos los push que se hacen al repositorio de bitbucket son capturados
y buildeados en un servidor de integración interno de Runroom.

Utilizamos la herramienta [Jenkins](https://jenkins.io/) como servidor de CI.

En esta herramienta tenemos configurado un sistema que nos permite gestionar
todas las ramas de forma individual. Es decir, cada branch de git va a tener su entorno
y su histórico de builds.

Las builds consisten en:

- Instalar las dependencias de composer
- Ejecutar los test unitarios
- Generar un reporte de covertura

Cuando las builds són de development o master y pasan los test, se procede a ejecutar otra tarea
de Jenkins que se encarga de hacer un deploy de la rama en el servidor correspondiente, utilizando
Capistrano.

Es decir, por defecto para hacer un deploy en el servidor de test, tenemos que subir el código a development
y para hacer un deploy en producción, lo subimos a master. Jenkins se encarga de comprobar que la build
pasa los tests y de hacer un deploy.

## Configuración

Por defecto tenemos 2 tareas, la que se encarga de hacer las builds y la que se encarga de deployar
el código. Se pueden generar tareas para utilizar este proceso en otro proyecto copiando las tareas y
cambiando la configuración especifica.
