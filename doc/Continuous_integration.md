# Continuous integration

All git pushes to the bitbucket repository are build by a continuous
integration server in Runroom.

We use the [Jenkins](https://jenkins.io/) continuous integration server.

In this tool we can manage al the repository branches individually. Each git branch 
has its own builds history.

Builds consist in:

- Install composer dependencies
- Run unit tests
- Generate coverage report

When Jenkins makes any build from the development or master branch and all tests pass, a different
task is launched to deploy that branch to its corresponding server. See [Deployment](Deployment.md) 
for more information.

So, to deploy the development version we should push to the development branch and to deploy to 
production we should push to the master branch. Jenkins takes care of building, testing and 
deploying to the server.

## Configuration

There are 2 different tasks in Jenkins. The first one builds and tests the code, then the second one 
deploys when necessary. You can just copy this tasks for your own projects.
