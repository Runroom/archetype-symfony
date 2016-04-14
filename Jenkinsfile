#!groovy

node {

  stage 'SCM'

  checkout scm

  stage 'Build'

  withEnv(['SYMFONY_ENV=test']) {
    sh 'curl -sS https://getcomposer.org/installer | php'
    sh 'php composer.phar selfupdate'
    sh 'php composer.phar install'
  }

  stage 'Test'

  sh 'bin/phpunit -c app --log-junit coverage/unitreport.xml'

  step([
    $class: 'JUnitResultArchiver',
    testResults: 'coverage/unitreport.xml'
  ])

  stage 'Deploy'

  if (env.JOB_NAME.endsWith('development')) {
    build job: 'gpcasinos_web_deploy', parameters: [
      [$class: 'StringParameterValue', name: 'PARENT_JOB', value: env.JOB_NAME],
      [$class: 'StringParameterValue', name: 'CAPISTRANO_ENV', value: 'development']
    ]
  }
  else if (env.JOB_NAME.endsWith('master')) {
    build job: 'gpcasinos_web_deploy', parameters: [
      [$class: 'StringParameterValue', name: 'PARENT_JOB', value: env.JOB_NAME],
      [$class: 'StringParameterValue', name: 'CAPISTRANO_ENV', value: 'master']
    ]
  }

}
