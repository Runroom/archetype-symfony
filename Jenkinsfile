#!groovy

node {

  stage 'SCM Checkout'

  checkout scm

  stage 'Build'

  sh 'curl -sS https://getcomposer.org/installer | php'
  sh 'php composer.phar selfupdate'
  sh 'php composer.phar install'

  stage 'Test'

  sh 'bin/phpunit -c app --coverage-clover coverage/coverage.xml --log-junit coverage/unitreport.xml'

  step([
    $class: 'CloverPublisher',
    cloverReportDir: 'coverage',
    cloverReportFileName: 'coverage.xml'
  ])

  step([
    $class: 'JUnitResultArchiver',
    testResults: 'coverage/unitreport.xml'
  ])

  stage 'Deploy'

  if ($JOB_NAME.endsWith('development')) {
    build job: 'gpcasinos_web_deploy', parameters: [
      [$class: 'StringParameterValue', name: 'PARENT_JOB', value: $JOB_NAME],
      [$class: 'StringParameterValue', name: 'CAPISTRANO_ENV', value: 'development']
    ]
  }
  else if ($JOB_NAME.endsWith('master')) {
    build job: 'gpcasinos_web_deploy', parameters: [
      [$class: 'StringParameterValue', name: 'PARENT_JOB', value: $JOB_NAME],
      [$class: 'StringParameterValue', name: 'CAPISTRANO_ENV', value: 'master']
    ]
  }

}
