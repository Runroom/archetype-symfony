Archetype Symfony
=================

![ci](https://github.com/Runroom/archetype-symfony/workflows/ci/badge.svg)
![qa](https://github.com/Runroom/archetype-symfony/workflows/qa/badge.svg)

## Requirements

To run this project, you need to have:

- [Git](https://git-scm.com/)
- [Nvm](https://github.com/nvm-sh/nvm)
- [NPM](https://www.npmjs.com/)
- [Mkcert](https://github.com/FiloSottile/mkcert)
- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/cli-command/)

## Setup

To start the project:

    make up

To generate build assets:

    nvm use
    npm clean-install
    npx encore dev

Open `https://localhost:8443` in your browser
Open `http://localhost:8025` in your browser to access MailHog

## Contribute

Please refer to [CONTRIBUTING](doc/Contributing.md) for information on how
to contribute to the Archetype and its related projects.

## Additional documentation

- [Code of conduct](doc/Code_of_conduct.md)
- [Continuous Integration](doc/Continuous_integration.md)
- [Contributing](doc/Contributing.md)
- [Cookies](doc/Cookies.md)
- [Deployment](doc/Deployment.md)
- [Docker](doc/Docker.md)
- [MailHog](doc/MailHog.md)
- [Migrations](doc/Migrations.md)
- [Frontend Architecture](doc/frontend/architecture/Index.md)
