Vagrant.require_version '>= 2.1.2'

vboxName = 'symfony-vm'
hostname = 'symfony.local'
aliases = []

Vagrant.configure('2') do |config|
    config.hostmanager.enabled = true
    config.hostmanager.manage_host = true
    config.hostmanager.manage_guest = true

    config.vm.provider :virtualbox do |vbox|
        vbox.linked_clone = true
        vbox.customize [
            'modifyvm', :id,
            '--name', vboxName,
            '--cpus', 1,
            '--memory', 1024,
            '--natdnshostresolver1', 'on',
            '--nictype1', 'virtio',
            '--nictype2', 'virtio',
        ]
    end

    config.vm.define 'symfony-vm' do |node|
        node.vm.box = 'ubuntu/bionic64'
        node.vm.network :private_network, ip: '192.168.33.99', nic_type: 'virtio'
        node.vm.network :forwarded_port, host: 3306, guest: 3306, auto_correct: true
        node.vm.network :forwarded_port, host: 5000, guest: 5000, auto_correct: true
        node.vm.network :forwarded_port, host: 5001, guest: 5001, auto_correct: true
        node.vm.hostname = hostname
        node.hostmanager.aliases = aliases

        node.vm.synced_folder './', '/vagrant', type: 'nfs', nfs_udp: false, mount_options: ['actimeo=1', 'async', 'noatime']
        node.ssh.forward_agent = true
    end

    config.trigger.before :provision do |trigger|
        trigger.run = {
            path: 'ansible/before.bash',
            args: hostname + ' ' + aliases.join(' ')
        }
    end

    config.vm.provision 'ansible_local' do |ansible|
        ansible.playbook = 'ansible/playbook.yaml'
    end
end
