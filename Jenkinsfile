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
      sh 'curl -sS https://getcomposer.org/installer | php7.0'
    }

    withEnv(['SYMFONY_ENV=test']) {
      sh 'php7.0 composer.phar install'
    }
  }

  stage('Test') {
    sh 'php7.0 vendor/bin/phpunit -c app --log-junit coverage/unitreport.xml'

    step([
      $class: 'JUnitResultArchiver',
      testResults: 'coverage/unitreport.xml'
    ])
  }

  stage('Deploy') {
    if (env.BRANCH_NAME.equalsIgnoreCase('development')) {
      build job: 'archetype_symfony_deploy', parameters: [
        [$class: 'StringParameterValue', name: 'BRANCH', value: 'development']
      ], wait: false
    }
    else if (env.BRANCH_NAME.equalsIgnoreCase('master')) {
      build job: 'archetype_symfony_deploy', parameters: [
        [$class: 'StringParameterValue', name: 'BRANCH', value: 'master']
      ], wait: false
    }
  }
}
