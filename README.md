# Runroom - Archetype Symfony

![ci](https://github.com/Runroom/archetype-symfony/workflows/ci/badge.svg)

## Requirements

To run this project, you need to have:

- [Git](https://git-scm.com/)
- [Nvm](https://github.com/nvm-sh/nvm)
- [Yarn](https://yarnpkg.com/)
- [VirtualBox](https://www.virtualbox.org/)
- [Vagrant](https://www.vagrantup.com/)
- [Vagrant Host Manager](https://github.com/devopsgroup-io/vagrant-hostmanager)
- [Mkcert](https://github.com/FiloSottile/mkcert)

## Setup

Virtual machine up:

    vagrant up

To generate build assets:

    nvm use
    yarn
    yarn encore dev

## Environment

Open `https://symfony.local` in your browser.

## Contribute

Please refer to [CONTRIBUTING](doc/Contributing.md) for information on how
to contribute to the Archetype and its related projects.

## Additional documentation

- [Ansible](doc/Ansible.md)
- [Code of conduct](doc/Code_of_conduct.md)
- [Configuration](doc/Configuration.md)
- [Continuous Integration](doc/Continuous_integration.md)
- [Contributing](doc/Contributing.md)
- [Cookies](doc/Cookies.md)
- [Deployment](doc/Deployment.md)
- [Migrations](doc/Migrations.md)
- [Frontend Architecture](doc/frontend/architecture/Index.md)
