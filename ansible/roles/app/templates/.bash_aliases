alias composer-install="{{ ansible_env.HOME }}/bin/composer install -o --working-dir=\"/vagrant\""
alias phpunit-coverage="phpdbg -qrr {{ ansible_env.HOME }}/vendor/bin/phpunit --coverage-html /vagrant/coverage"
alias phpstan-analyse="{{ ansible_env.HOME }}/vendor/bin/phpstan analyse --level=max src tests"

if [ -f /vagrant/.vault_pass ]; then
    export ANSIBLE_VAULT_PASSWORD_FILE=/vagrant/.vault_pass
fi

ansible-run () {
    ansible-playbook /vagrant/ansible/playbook.yaml -i "localhost," -c local --tags "$1";
}
