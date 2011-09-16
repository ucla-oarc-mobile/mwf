# This installation script for RHEL, CentOS and Fedora configures default
# location directories for the MWF. This should be run first when 
# installing the MWF on a new server.

install_dir="/var/mobile"

sudo mkdir ${install_dir}
sudo mkdir ${install_dir}/cache
sudo mkdir ${install_dir}/cache/img
sudo mkdir ${install_dir}/cache/simplepie

sudo chmod 755 ${install_dir}/cache/img
sudo chmod 755 ${install_dir}/cache/simplepie

sudo chown apache.apache ${install_dir}/cache/img
sudo chown apache.apache ${install_dir}/cache/simplepie
