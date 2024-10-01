# Deployment

Archetype deployments use the [Kamal](https://kamal-deploy.org/) tool. It can be configured through the files located on the .kamal directory.

For more options see the [Kamal documentation](https://kamal-deploy.org/docs/installation).

## Previous considerations

Before doing any deployment you will need:

- A Linux server (Docker will be installed with Kamal automatically)
- An image pushed to a Docker registry (of our application, ideally tagged as `latest`)
- We will setup both `production` and `staging` to the same server and we will use the same database for both environments.

## Preparing the server

You will need to follow this steps:

1. Before executing any command we have to make sure to have a `.env` file with all the variables for our application ready for the staging server,
because everything on the .env will be copied to the server. We have to add all the variables on the `.kamal/.env.example` to the `.env` temporarily,
those are needed for the accessories of this project. You can change the values later, located at `~/.kamal/env`.

2. Upload Traefik configuration files to the server. This configuration will also depend on how you want to manager your certificates.
On this example we want to use an origin certificate generated on Cloudflare, so we will upload it to `~/traefik/certs` and create a `conf.yml` on
`~/traefik/conf.yml` with the following content:

```yaml
tls:
    certificates:
        - certFile: /certs/cert.crt
          keyFile: /certs/cert.key
```

3. Create initial version of shared files:

  - robots.txt: `~/staging/robots.txt` and `~/production/robots.txt`

When everything is ready, to prepare the server, you can use the command:

```bash
make deploy-setup
```

This command will install Docker on the server and deploy application. In case you are deploying multiple applications, remember that you only need to do the setup once,
but you will need to push the environment variables and deploy each application separately.

## Deploying

Normally you want to deploy using your CI/CD tool, but you can also deploy manually. To initiate a normal deployment you can use:

```bash
make deploy
```

This command has a default of deploying to `staging` the `latest` version. You can modify the `DESTINATION` variable to deploy to another server:

```bash
make deploy DESTINATION=production
```

You can also change the deployment version by setting the `VERSION` variable:

```bash
make deploy VERSION=1.0.0
```

Those variables also work with the `deploy-setup` command.

## Modify environment variables

Another command that is better suited for executing in a CI/CD environment is the `deploy-env` command:

```bash
make deploy-env-push
```

This command will modify the environment variables of the server.

## Rolling back

If you need to rollback to a previous version you can use the `deploy` command with the `VERSION` variable:

```bash
make deploy VERSION=1.9.0
```

## Other commands

There are other commands available to help you with the deployment process. You can check them in the Makefile [file](.docker/make/05_deploy.mk).
