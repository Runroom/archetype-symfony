# Despliegue

Como sistema de despliegue se utiliza [Capistrano](http://capistranorb.com/)

El fichero principal de configuración es [deploy.rb](config/deploy.rb)

Además hay dos archivos de configuración para las dos ramas principales de
desarrollo: development y master.


## Development

El fichero de configuración para el despliegue de development es
[development.rb](config/deploy/development.rb). Para realizar un
despliegue se ejecuta:

    cap development deploy


## Master

El fichero de configuración para el despliegue de master es
[master.rb](config/deploy/master.rb). Para realizar un
despliegue se ejecuta:

    cap master deploy
