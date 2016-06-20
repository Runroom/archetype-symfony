#!groovy

node {

  stage 'Configuration'

  properties([
    [
      $class: 'BuildDiscarderProperty',
      strategy: [
        $class: 'LogRotator',
        daysToKeepStr: '',
        numToKeepStr: '10',
        artifactDaysToKeepStr: '',
        artifactNumToKeepStr: ''
      ]
    ]
  ])

  stage 'SCM'

  checkout scm

  stage 'Build'

  if (!fileExists('composer.phar')) {
    sh 'curl -sS https://getcomposer.org/installer | php'
  }

  withEnv(['SYMFONY_ENV=test']) {
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
    build job: 'archetype_symfony_deploy', parameters: [
      [$class: 'StringParameterValue', name: 'BRANCH', value: 'development'],
      [$class: 'StringParameterValue', name: 'CAPISTRANO', value: 'development']
    ], wait: false
  }
  else if (env.JOB_NAME.endsWith('master')) {
    build job: 'archetype_symfony_deploy', parameters: [
      [$class: 'StringParameterValue', name: 'BRANCH', value: 'master'],
      [$class: 'StringParameterValue', name: 'CAPISTRANO', value: 'master']
    ], wait: false
  }

}
