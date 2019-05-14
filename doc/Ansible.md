# Ansible

We use [Vagrant](https://www.vagrantup.com/) to create our development
environment. [Ansible](https://www.ansible.com/) is then used to provision
the virtual machine with the needed software and settings.

Ansible parameters such as passwords are encrypted in the [secure.yaml](../ansible/vars/secure.yaml)
file. It looks like this:

    db:
        host: <ip>
        name: <name>
        user: <user>
        password: <password>
    symfony:
        secret: <secret_token>

You only need to create this file (or replace it) and fill each field.

To make Ansible able to decrypt this file we need a to create a `.vault_pass`
file with the password used to encrypt the secure.yaml file. You can do it like
this:

    echo 'awesome_secret_password' > .vault_pass

Last, to encrypt the `secure.yaml` use this command:

    ansible-vault encrypt ansible/vars/secure.yaml --vault-password-file .vault_pass
