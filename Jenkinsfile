#!groovy

PROJECT_NAME = env.JOB_NAME.replace('/' + env.JOB_BASE_NAME, '')

pipeline {
    agent {
        docker {
            image 'runroom/php7.3-cli'
            args '--user root:root'
        }
    }

    options { buildDiscarder(logRotator(numToKeepStr: '5')) }

    stages {
        stage('Build') {
            steps {
                sh 'composer install --prefer-dist --classmap-authoritative --no-progress --no-interaction'
            }
        }
        stage('Test') {
            steps {
                sh 'phpdbg -qrr ./vendor/bin/phpunit --log-junit coverage/unitreport.xml --coverage-html coverage'
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
        fixed { slackSend(color: 'good', message: "Fixed - ${PROJECT_NAME} - ${env.BUILD_DISPLAY_NAME} (<${env.BUILD_URL}|Open>)\n${env.BRANCH_NAME}")}
        failure { slackSend(color: 'danger', message: "Failed - ${PROJECT_NAME} - ${env.BUILD_DISPLAY_NAME} (<${env.BUILD_URL}|Open>)\n${env.BRANCH_NAME}") }
    }
}
