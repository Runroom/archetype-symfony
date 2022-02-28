# Continuous integration

All git pushes to the bitbucket repository are build by a continuous
integration server in Runroom.

We use the [Jenkins](https://jenkins.io/) continuous integration server.

In this tool we can manage al the repository branches individually. Each git branch 
has its own builds history.

Builds consist in:

- Install composer dependencies
- Run unit tests
- Run all QA tools
- Run frontend build
- Generate coverage report

When Jenkins makes a build for the main branch and all checks pass, a different
task is launched to deploy that branch to the production server. See [Deployment](Deployment.md) 
for more information.

## Configuration

There are 2 different tasks in Jenkins. The first one builds and tests the code, then the second one 
deploys when necessary. You can just copy this tasks for your own projects.
