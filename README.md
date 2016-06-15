# Symfony Archetype

## Setup

Clone repository:

    git clone git@bitbucket.org:runroom/archetype-symfony.git

Virtual machine up:

    vagrant up


## Environments

### Development

Add symfony.dev to hosts:

    echo '192.168.33.99 symfony.dev' | sudo tee --append /etc/hosts

Open `http://symfony.dev` in your browser.


## Testing

Run `phpunit -c app` to perform tests.

NOTE: Append `--coverage-html coverage` to generate coverage.


## Releases

### Development

To deploy a new release just commit and push changes to development branch:

    git add -A
    git commit -m "<message>"
    git push origin development

### Production

To deploy a new release just merge development to master:

    git checkout master
    git merge development
    git push origin master

Or commit and push changes to master branch directly:

    git add -A
    git commit -m "<message>"
    git push origin master


## Additional documentation

- [Ansible](doc/Ansible.md)
- [Deploy](doc/Despliegue.md)
- [Continuous Integration](doc/Integracion_continua.md)
- [Migrations](doc/Migraciones.md)
