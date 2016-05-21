Vagrant.require_version '>= 1.8.0'

Vagrant.configure('2') do |config|
    config.vm.provider :virtualbox do |v|
        v.name = 'symfony_archetype_vm'
        v.customize [
            'modifyvm', :id,
            '--name', 'symfony_archetype_vm',
            '--memory', 2048,
            '--natdnshostresolver1', 'on',
            '--cpus', 2,
        ]
    end

    config.vm.box = 'ubuntu/trusty64'
    config.vm.network :private_network, ip: '192.168.33.99'
    config.vm.network :forwarded_port, host: 5000, guest: 5000
    config.vm.network :forwarded_port, host: 5001, guest: 5001
    config.vm.synced_folder './', '/vagrant', type: 'nfs', mount_options: ['actimeo=1']
    config.ssh.forward_agent = true

    # Patch for https://github.com/mitchellh/vagrant/issues/6793
    config.vm.provision 'shell' do |shell|
        shell.privileged = false
        shell.inline = <<-SCRIPT
            GALAXY=/usr/local/bin/ansible-galaxy
            echo '#!/usr/bin/env bash
            /usr/bin/ansible-galaxy "$@"
            exit 0
            ' | sudo tee $GALAXY
            sudo chmod 0755 $GALAXY
        SCRIPT
    end

    config.vm.provision 'ansible_local' do |ansible|
        ansible.playbook = 'ansible/playbook.yml'
        ansible.limit = 'all'
    end
end
