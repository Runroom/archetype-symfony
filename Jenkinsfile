#!groovy

PROJECT_NAME = env.JOB_NAME.replace('/' + env.JOB_BASE_NAME, '')
SLACK_ERROR_MESSAGE = "${PROJECT_NAME} - ${env.BUILD_DISPLAY_NAME} Failed (<${env.BUILD_URL + 'console'}|Open>)\n${env.BRANCH_NAME}"
COMPOSER = '/usr/local/bin/composer'
PHP_VERSION = '7.1'

pipeline {
    agent any

    options { buildDiscarder(logRotator(numToKeepStr: '10')) }

    stages {
        stage('Build') {
            steps {
                sh "php${PHP_VERSION} ${COMPOSER} self-update"
                withEnv(['SYMFONY_ENV=test']) {
                    sh "php${PHP_VERSION} ${COMPOSER} install --prefer-dist --classmap-authoritative --no-progress --no-interaction --no-scripts"
                }
            }
        }
        stage('Test') {
            steps {
                sh "php${PHP_VERSION} vendor/bin/phpunit --log-junit coverage/unitreport.xml --coverage-html coverage --coverage-clover coverage/cloverreport.xml"
                step([ $class: 'JUnitResultArchiver', testResults: 'coverage/unitreport.xml' ])
                publishHTML(target: [
                    allowMissing: false,
                    alwaysLinkToLastBuild: false,
                    keepAll: true,
                    reportDir: 'coverage',
                    reportFiles: 'index.html',
                    reportName: 'Coverage Report'
                ])
            }
        }
        stage('Deploy') {
            when { expression { return env.BRANCH_NAME in ['development'] } }
            steps {
                build job: "${PROJECT_NAME}_deploy", parameters: [
                    [$class: 'StringParameterValue', name: 'BRANCH', value: env.BRANCH_NAME]
                ], wait: false
            }
        }
        stage('Analysis') {
            when { expression { return env.BRANCH_NAME in ['development'] } }
            steps {
                script {
                    def scannerHome = tool name: 'SonarQube Scanner', type: 'hudson.plugins.sonar.SonarRunnerInstallation'
                    withSonarQubeEnv('SonarQube') {
                        sh "${scannerHome}/bin/sonar-scanner"
                    }
                }
            }
        }
    }

    post {
        failure { slackSend(color: 'danger', message: SLACK_ERROR_MESSAGE) }
    }
}
