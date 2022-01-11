#!groovy

PROJECT_NAME = env.JOB_NAME.replace('/' + env.JOB_BASE_NAME, '')

pipeline {
    agent any

    environment {
        APP_ENV = 'test'
    }

    options {
        buildDiscarder(logRotator(numToKeepStr: '5'))
        disableConcurrentBuilds()
    }

    stages {
        stage('Continuous Integration - PHP') {
            agent {
                docker { image 'runroom/php8.0-cli' }
            }

            steps {
                // Install
                sh 'composer install --prefer-dist --no-progress --no-interaction'

                // Lint + QA
                sh 'composer php-cs-fixer -- --dry-run'
                sh 'composer phpstan'
                sh 'composer psalm -- --threads=$(nproc)'
                sh 'composer normalize --dry-run'
                sh 'composer lint-yaml'
                sh 'composer lint-twig'

                // Tests
                sh 'vendor/bin/phpunit --log-junit coverage/unitreport.xml --coverage-html coverage'

                // Report
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

        stage('Continuous Integration - Node') {
            agent {
                docker { image 'runroom/node17' }
            }

            steps {
                // Install
                sh 'npm clean-install'

                // Lint + QA
                sh 'npx stylelint assets/css'
                sh 'npx eslint assets/js'
                sh 'npx prettier --check .github config assets translations webpack.config.js babel.config.js .eslintrc.js stylelint.config.js postcss.config.js prettier.config.js docker-compose.yaml servers.yaml'

                // Build
                sh 'npx encore production'
            }
        }

        stage('Continuous Deployment') {
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
