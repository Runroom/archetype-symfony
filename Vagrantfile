Vagrant.require_version '>= 1.8.0'

Vagrant.configure('2') do |config|

    config.vm.provider :virtualbox do |v|
        v.name = 'gpcasinos_vm'
        v.customize [
            'modifyvm', :id,
            '--name', 'gpcasinos_vm',
            '--memory', 2048,
            '--natdnshostresolver1', 'on',
            '--cpus', 1,
        ]
    end

    config.vm.box = 'ubuntu/trusty64'

    config.vm.network :private_network, ip: '192.168.33.99'
    config.ssh.forward_agent = true

    # Patch for https://github.com/mitchellh/vagrant/issues/1673
    config.vm.provision 'shell' do |s|
        s.privileged = false
        s.inline = "sudo sed -i '/tty/!s/mesg n/tty -s \\&\\& mesg n/' /root/.profile"
    end

    # Patch for https://github.com/mitchellh/vagrant/issues/6793
    config.vm.provision 'shell' do |s|
        s.inline = '[[ ! -f $1 ]] || grep -F -q "$2" $1 || sed -i "/__main__/a \\    $2" $1'
        s.args = ['/usr/bin/ansible-galaxy', "if sys.argv == ['/usr/bin/ansible-galaxy', '--help']: sys.argv.insert(1, 'info')"]
    end

    config.vm.provision 'ansible_local' do |ansible|
        ansible.playbook = 'ansible/playbook.yml'
        ansible.inventory_path = 'ansible/inventory'
        ansible.vault_password_file = '.vault_pass'
        ansible.limit = 'all'
    end

    config.vm.synced_folder './', '/vagrant', type: 'nfs', mount_options: ['actimeo=1']
end
