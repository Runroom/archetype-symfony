# Ansible

Como entorno de desarrollo se usa [Vagrant](https://www.vagrantup.com/) y para
la automatización de las tareas de instalación y actualización se usa
[Ansible](https://www.ansible.com/).


Aquellos parámetros de ansible que se consideran sensibles se encuentran
cifrados en [secure.yml](src/master/ansible/vars/secure.yml). Los datos que
contiene este fichero son:

    db:
        host: <ip>
        name: <name>
        user: <user>
        password: <password>
    symfony:
        secret: <secret_token>

Solo hay que crear este fichero (o reemplazarlo) y rellenar cada campo.


Para que Ansible sea capaz de descifrar este archivo a la hora de configurar la
máquina virtual es necesario crear un fichero llamado `.vault_pass` que contenga
la contraseña que se utilizó para cifrar previamente el archivo secure.yml, se
puede hacer de la siguiente manera:

    echo 'awesome_secret_password' > .vault_pass


Por último solo hay que cifrar `secure.yml` ejecutando:

    ansible-vault encrypt ansible/vars/secure.yml --vault-password-file .vault_pass
