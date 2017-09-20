alias composer-install="{{ ansible_env.HOME }}/bin/composer install -o --working-dir=\"/vagrant\""
alias phpunit-coverage="php -dzend_extension=xdebug.so {{ ansible_env.HOME }}/vendor/bin/phpunit --coverage-html /vagrant/coverage"
alias phpmd="{{ ansible_env.HOME }}/vendor/bin/phpmd /vagrant/src text phpmd.xml"

ansible-run () {
    ansible-playbook /vagrant/ansible/playbook.yml -i "localhost," -c local --tags "$1";
}
