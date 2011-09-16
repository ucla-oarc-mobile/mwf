# This installation script for RHEL, CentOS and Fedora configures default
# location directories for the MWF. This should be run first when 
# installing the MWF on a new server.

install_dir="/var/mobile"

sudo mkdir -p ${install_dir}/cache/img
sudo mkdir -p ${install_dir}/cache/simplepie

sudo chmod 755 ${install_dir}/cache/img
sudo chmod 755 ${install_dir}/cache/simplepie

web_user=`ps axho user,comm|grep -E "httpd|apache"|uniq|awk 'END {print $1}'`

sudo chown $web_user ${install_dir}/cache/img
sudo chown $web_user ${install_dir}/cache/simplepie
