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
      sh 'php7.0 composer.phar install --classmap-authoritative --prefer-dist --no-progress --no-interaction'
    }
  }

  stage('Test') {
    sh 'php7.0 vendor/bin/phpunit --log-junit coverage/unitreport.xml --coverage-clover coverage/clover.xml'

    step([
      $class: 'JUnitResultArchiver',
      testResults: 'coverage/unitreport.xml'
    ])

    step([
      $class: 'CloverPublisher',
      cloverReportFileName: 'coverage/clover.xml'
    ])
  }

  stage('Deploy') {
    if (env.BRANCH_NAME in ['development', 'master']) {
      build job: 'archetype_symfony_deploy', parameters: [
        [$class: 'StringParameterValue', name: 'BRANCH', value: env.BRANCH_NAME]
      ], wait: false
    }
  }
}
