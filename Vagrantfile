Vagrant.require_version '>= 2.1.2'

Vagrant.configure('2') do |config|
    config.hostmanager.enabled = true
    config.hostmanager.manage_host = true
    config.hostmanager.manage_guest = true

    config.vm.provider :virtualbox do |v|
        v.linked_clone = true
        v.customize [
            'modifyvm', :id,
            '--name', 'symfony-vm',
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
        node.vm.network :forwarded_port, host: 5000, guest: 5000, auto_correct: true
        node.vm.network :forwarded_port, host: 5001, guest: 5001, auto_correct: true
        node.vm.hostname = 'symfony.local'
        node.hostmanager.aliases = []

        node.vm.synced_folder './', '/vagrant', type: 'nfs', nfs_udp: false, mount_options: ['actimeo=1']
        node.ssh.forward_agent = true
    end

    config.vm.provision 'ansible_local' do |ansible|
        ansible.compatibility_mode = '2.0'
        ansible.playbook = 'ansible/playbook.yml'
    end
end
