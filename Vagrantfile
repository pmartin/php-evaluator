# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
  config.vm.box = "ubuntu/xenial64"
  config.vm.box_check_update = false
  config.vm.provider "virtualbox"

  if Vagrant.has_plugin?("vagrant-cachier")
    config.cache.scope = :box
  end

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine. In the example below,
  # accessing "localhost:8080" will access port 80 on the guest machine.
  config.vm.network "forwarded_port", guest: 80, host: 49080

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.
  # config.vm.network "private_network", ip: "192.168.33.10"

  # Create a public network, which generally matched to bridged network.
  # Bridged networks make the machine appear as another physical device on
  # your network.
  # config.vm.network "public_network"

  config.vm.synced_folder ".", "/vagrant", disabled: true
  config.vm.synced_folder "./vagrant-files", "/tmp/vagrant-files"
  config.vm.synced_folder "./workshop/www", "/var/www"

  config.vm.provider "virtualbox" do |vb|
    vb.gui = false
    vb.memory = 1024
    vb.cpus = 2
    vb.name = "php-evaluator"
  end

  config.vm.provision "shell", path: 'vagrant-files/vagrant-provision.sh'
end
