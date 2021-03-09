#!groovy

PROJECT_NAME = env.JOB_NAME.replace('/' + env.JOB_BASE_NAME, '')

pipeline {
    agent {
        docker { image 'runroom/php7.4-cli' }
    }

    options {
        buildDiscarder(logRotator(numToKeepStr: '5'))
        disableConcurrentBuilds()
    }

    stages {
        stage('Build') {
            steps {
                sh 'composer-v2 install --prefer-dist --no-progress --no-interaction'
            }
        }
        stage('Test') {
            steps {
                sh 'vendor/bin/phpunit --log-junit coverage/unitreport.xml --coverage-html coverage'

                xunit([PHPUnit(
                    deleteOutputFiles: false,
                    failIfNotNew: false,
                    pattern: 'coverage/unitreport.xml',
                    skipNoTestFiles: true,
                    stopProcessingIfError: false
                )])
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
        stage('Quality Assurance') {
            steps {
                sh 'composer-v2 php-cs-fixer -- --dry-run'
                sh 'composer-v2 phpstan'
                sh 'composer-v2 psalm -- --threads=$(nproc)'
                sh 'composer-v2 normalize --dry-run'
                sh 'composer-v2 lint-yaml'
                sh 'composer-v2 lint-twig'
            }
        }
        stage('Deploy') {
            when { expression { return env.BRANCH_NAME in ['master'] } }
            steps {
                build job: "${PROJECT_NAME} Deploy", parameters: [
                    [$class: 'StringParameterValue', name: 'BRANCH', value: env.BRANCH_NAME]
                ], wait: false
            }
        }
    }

    post {
        always { cleanWs() }
        fixed { slackSend(color: 'good', message: "Fixed - ${PROJECT_NAME} - ${env.BUILD_DISPLAY_NAME} (<${env.BUILD_URL}|Open>)\n${env.BRANCH_NAME}")}
        failure { slackSend(color: 'danger', message: "Failed - ${PROJECT_NAME} - ${env.BUILD_DISPLAY_NAME} (<${env.BUILD_URL}|Open>)\n${env.BRANCH_NAME}") }
    }
}
