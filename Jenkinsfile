#!groovy

node {
  stage('Configuration') {
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
  }

  stage('SCM') {
    checkout scm
  }

  stage('Build') {
    if (!fileExists('composer.phar')) {
      sh 'curl -sS https://getcomposer.org/installer | php5.6'
    }

    withEnv(['SYMFONY_ENV=test']) {
      sh 'php5.6 composer.phar install'
    }
  }

  stage('Test') {
    sh 'php5.6 bin/phpunit -c app --log-junit coverage/unitreport.xml'

    step([
      $class: 'JUnitResultArchiver',
      testResults: 'coverage/unitreport.xml'
    ])
  }

  stage('Deploy') {
    if (env.JOB_NAME.endsWith('development')) {
      build job: 'archetype_symfony_deploy', parameters: [
        [$class: 'StringParameterValue', name: 'BRANCH', value: 'development']
      ], wait: false
    }
    else if (env.JOB_NAME.endsWith('master')) {
      build job: 'archetype_symfony_deploy', parameters: [
        [$class: 'StringParameterValue', name: 'BRANCH', value: 'master']
      ], wait: false
    }
  }
}
