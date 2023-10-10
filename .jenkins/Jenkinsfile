#!groovy

pipeline {
    agent any

    environment {
        APP_ENV = 'test'
        FOLDER_NAME = "${JOB_NAME.split('/')[0]}"
    }

    options {
        buildDiscarder(logRotator(numToKeepStr: '5'))
        disableConcurrentBuilds(abortPrevious: true)
        disableResume()
    }

    stages {
        stage('Continuous Integration') {
            parallel {
                stage('PHP') {
                    agent {
                        docker {
                            image 'runroom/php8.2-cli'
                            args '-v $HOME/composer:/home/jenkins/.composer:z'
                            reuseNode true
                        }
                    }

                    steps {
                        sh 'composer install --no-progress --no-interaction'

                        sh 'composer php-cs-fixer -- --dry-run'
                        sh 'composer phpstan'
                        sh 'composer psalm -- --threads=$(nproc)'
                        sh 'composer rector -- --dry-run'
                        sh 'composer normalize --dry-run'
                        sh 'composer lint-container'
                        sh 'composer lint-yaml'
                        sh 'composer lint-twig'

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

                stage('Node') {
                    agent {
                        docker {
                            image 'runroom/node18'
                            args '-v $HOME/npm:/home/node/.npm:z'
                            reuseNode true
                        }
                    }

                    steps {
                        sh 'npm clean-install'

                        sh 'npm run lint'

                        sh 'npm run build'
                    }
                }
            }
        }
    }

    post {
        always { cleanWs deleteDirs: true, patterns: [
            [pattern: '**/.cache/**', type: 'EXCLUDE'],
        ] }
        fixed { slackSend(color: 'good', message: "Fixed - ${FOLDER_NAME} - ${BUILD_DISPLAY_NAME} (<${BUILD_URL}|Open>)\n${BRANCH_NAME}")}
        failure { slackSend(color: 'danger', message: "Failed - ${FOLDER_NAME} - ${BUILD_DISPLAY_NAME} (<${BUILD_URL}|Open>)\n${BRANCH_NAME}") }
    }
}
