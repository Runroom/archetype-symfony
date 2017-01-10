alias composer-install="/home/{{ ansible_user }}/bin/composer install --classmap-authoritative --working-dir=\"/vagrant\""
alias phpunit-coverage="php -dzend_extension=xdebug.so /home/{{ ansible_user }}/vendor/bin/phpunit --coverage-html /vagrant/coverage"
alias phpmd="/home/{{ ansible_user }}/vendor/bin/phpmd /vagrant/src text phpmd.xml"
