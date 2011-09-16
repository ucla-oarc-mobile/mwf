# This installation script for RHEL, CentOS and Fedora configures default
# location directories for the MWF. This should be run first when 
# installing the MWF on a new server.

install_dir="/var/mobile"

old_umask=`umask`
umask 0022
sudo mkdir -p ${install_dir}/cache/img
sudo mkdir -p ${install_dir}/cache/simplepie
umask $old_umask

web_user=`ps axho user,comm|grep -E "httpd|apache"|uniq|awk 'END {print $1}'`

sudo chown $web_user ${install_dir}/cache/img
sudo chown $web_user ${install_dir}/cache/simplepie
