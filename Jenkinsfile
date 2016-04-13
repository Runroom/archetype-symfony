#!groovy

node {

  stage 'SCM Checkout'

  checkout scm

  stage 'Build'

  sh 'curl -sS https://getcomposer.org/installer | php'
  sh 'php composer.phar selfupdate'
  sh 'php composer.phar install'

  stage 'Test'

  sh 'bin/phpunit -c app --coverage-clover coverage/coverage.xml --log-junit coverage/unitreport.xml'
  step([$class: 'JUnitResultArchiver', testResults: 'coverage/unitreport.xml'])

}
