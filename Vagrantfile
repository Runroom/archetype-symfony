Vagrant.require_version '>= 1.8.3'

Vagrant.configure('2') do |config|
    config.hostmanager.enabled = true
    config.hostmanager.manage_host = true
    config.hostmanager.manage_guest = true

    config.vm.provider :virtualbox do |v|
        v.customize [
            'modifyvm', :id,
            '--memory', 2048,
            '--natdnshostresolver1', 'on',
            '--cpus', 1,
            '--nictype1', 'virtio',
            '--nictype2', 'virtio',
        ]
    end

    config.vm.define 'symfony-vm' do |node|
        node.vm.box = 'ubuntu/trusty64'

        node.vm.network :private_network, ip: '192.168.33.99', nic_type: 'virtio'
        node.vm.network :forwarded_port, host: 5000, guest: 5000
        node.vm.network :forwarded_port, host: 5001, guest: 5001
        node.vm.hostname = 'symfony.dev'
        node.hostmanager.aliases = []

        node.vm.synced_folder './', '/vagrant', type: 'nfs', mount_options: ['rw', 'vers=3', 'tcp', 'fsc', 'actimeo=1']
        node.ssh.forward_agent = true
    end

    config.vm.provision 'ansible_local' do |ansible|
        ansible.playbook = 'ansible/playbook.yml'
    end
end
