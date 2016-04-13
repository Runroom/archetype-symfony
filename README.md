# Grup Peralada Casinos Web


## Setup

Clone repository:

    git clone git@bitbucket.org:runroom/gpcasinos_web.git

Create ansible secure vars: [Ansible](src/master/doc/Ansible.md)

Virtual machine up:

    vagrant up


## Environments

### Development

Add casinobarcelona.dev to hosts:

    echo '192.168.33.99 casinobarcelona.dev' | sudo tee --append /etc/hosts

Open `http://casinobarcelona.dev` in your browser.


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

- [Ansible](src/master/doc/Ansible.md)
- [Deploy](src/master/doc/Despliegue.md)
- [Continuous Integration](src/master/doc/Integracion continua.md)
- [Migrations](src/master/doc/Migraciones.md)
