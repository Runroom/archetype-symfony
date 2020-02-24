alias phpunit-coverage="phpdbg -qrr {{ ansible_env.HOME }}/vendor/bin/phpunit --coverage-html /vagrant/coverage"

if [ -f /vagrant/.vault_pass ]; then
    export ANSIBLE_VAULT_PASSWORD_FILE=/vagrant/.vault_pass
fi

ansible-run () {
    ansible-playbook /vagrant/ansible/playbook.yaml -i "localhost," -c local --tags "$1";
}
