#!groovy

node {
  try {
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
        sh 'php7.0 composer.phar install -an --prefer-dist --no-progress --apcu-autoloader'
      }
    }

    stage('Test') {
      sh 'php7.0 vendor/bin/phpunit --log-junit coverage/unitreport.xml --coverage-html coverage'

      step([
        $class: 'JUnitResultArchiver',
        testResults: 'coverage/unitreport.xml'
      ])

      publishHTML(target: [
        allowMissing: false,
        alwaysLinkToLastBuild: false,
        keepAll: true,
        reportDir: 'coverage',
        reportFiles: 'index.html',
        reportName: 'Coverage Report'
      ])
    }

    stage('Deploy') {
      if (env.BRANCH_NAME in ['development', 'master']) {
        build job: 'archetype_symfony_deploy', parameters: [
          [$class: 'StringParameterValue', name: 'BRANCH', value: env.BRANCH_NAME]
        ], wait: false
      }
    }
  } catch(error) {
    slackSend(
      color: 'danger',
      message: "Build Failed: '${env.JOB_NAME} ${env.BUILD_DISPLAY_NAME}' (<${env.BUILD_URL}|Open>)"
    )
  }
}
