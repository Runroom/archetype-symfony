#!groovy

FOLDER_NAME = env.JOB_NAME.split('/')[0]

pipeline {
    agent any

    environment {
        APP_ENV = 'test'
        DOCKER_BUILDKIT = 1
        DOCKER_REGISTRY = 'ghcr.io'
        CLEAN_BRANCH_NAME = env.BRANCH_NAME.replace('/', '-')
        SHORT_COMMIT = "${GIT_COMMIT[0..7]}"
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
                        // Install
                        sh 'composer install --no-progress --no-interaction'

                        // Lint + QA
                        sh 'composer php-cs-fixer -- --dry-run'
                        sh 'composer phpstan'
                        sh 'composer psalm -- --threads=$(nproc)'
                        sh 'composer rector -- --dry-run'
                        sh 'composer normalize --dry-run'
                        sh 'composer lint-container'
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

                stage('Build') {
                    when {
                        branch 'main'
                        changeRequest()
                    }

                    steps {
                        script {
                            def app = docker.build("ghcr.io/runroom/archetype-symfony", '--target app-prod ./.docker')

                            docker.withRegistry(DOCKER_REGISTRY, DOCKER_REGISTRY_AUTH) {
                                app.push("jenkins-sha-${SHORT_COMMIT}")

                                if (env.BRANCH_NAME == 'main') {
                                    app.push('jenkins-main')
                                    app.push('jenkins-latest')
                                }

                                if (env.CHANGE_ID) {
                                    app.push("jenkins-pr-${env.CHANGE_ID}")
                                }
                            }
                        }
                    }
                }
            }
        }

        // stage('Continuous Deployment - Production') {
        //     when { branch 'main' }
        //     steps {
        //         build job: "${FOLDER_NAME}/Production Deploy", wait: false
        //     }
        // }
    }

    post {
        always { cleanWs deleteDirs: true, patterns: [
            [pattern: '**/.cache/**', type: 'EXCLUDE'],
            [pattern: 'node_modules', type: 'EXCLUDE']
        ] }
        fixed { slackSend(color: 'good', message: "Fixed - ${FOLDER_NAME} - ${env.BUILD_DISPLAY_NAME} (<${env.BUILD_URL}|Open>)\n${env.BRANCH_NAME}")}
        failure { slackSend(color: 'danger', message: "Failed - ${FOLDER_NAME} - ${env.BUILD_DISPLAY_NAME} (<${env.BUILD_URL}|Open>)\n${env.BRANCH_NAME}") }
    }
}
