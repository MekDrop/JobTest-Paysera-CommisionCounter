# -*- mode: ruby -*-
# vi: set ft=ruby :

# -----------------------------------------------------------------------------
# This is file that was automatically generated with vagrant-impressbox plugin.
# We recommend do not edit it or at least do not use again impressbox command
# because this file will be overwritten in that case. If you want to set some
# special values for vagrant box, use config.yaml instead.
#
# If you want to use this vagrant file, make sure that git app is in your cmd
# path. Otherwise will crash!
# -----------------------------------------------------------------------------
# Last generation date:	2017-01-13 15:24:20 +0200
# More information:		http://impresscms.org
# -----------------------------------------------------------------------------

# Installs required plugins if not installed
if ARGV.include?('up')
  needed_reboot = false
  [
    'vagrant-impressbox',
    'vagrant-hostmanager'
  ].each do |plugin|
    unless Vagrant.has_plugin?(plugin)
      system 'vagrant plugin install ' + plugin
      needed_reboot = true
    end
  end
  if needed_reboot
    system 'vagrant up'
    exit true
  end
  needed_reboot = nil
end

# Configure vagrant
Vagrant.configure(2) do |config|
  config.vm.box = 'gbarbieru/xenial'
  config.vm.provision :impressbox
end
