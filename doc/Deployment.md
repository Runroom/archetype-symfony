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

1. Before executing any command we have to make sure to have a `.kamal/.env` file with all the variables for our application ready for the `staging` server.
Make sure to add the variables on the `.kamal/.env.example`. Those variables are needed to access the correct server and have the credentials for the registry

2. Create a `.kamal/secrets.staging` file with the secrets for the `staging` server. This file will be used to set the environment variables on the server.
Normally you will create this file using a secrets manager like Bitwarden Secrets Manager. You can use the command:

```bash
bws secret list <bws_project_id> --output=env > .kamal/secrets.staging
```

3. Create initial version of shared files:

  - robots.txt: `~/archetype-symfony-app/staging/robots.txt` and `~/archetype-symfony-app/production/robots.txt`

When everything is ready, to prepare the server, you can use the command:

```bash
make deploy-setup
```

This command will install Docker on the server and deploy the application. In case you are deploying multiple applications,
remember that you only need to do the setup once, but you will need to deploy each application separately.

## Deploying

> [!WARNING]
> Normally you want to deploy using your CI/CD tool, but there could be certain cases where you might want to execute a manual deployment.

To initiate a normal deployment you can use:

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

## Rolling back

If you need to rollback to a previous version you can use the `deploy` command with the `VERSION` variable:

```bash
make deploy VERSION=1.9.0
```

## Other commands

There are other commands available to help you with the deployment process. You can check them in the Makefile [file](../.docker/make/05_deploy.mk).
