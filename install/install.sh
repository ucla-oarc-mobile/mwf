# This installation script from RHEL, CentOS and Fedora configures default
# location files and directories for the MWF. It also fetches the latest copy
# of the WURFL metadata file. This should be run first when installing the MWF
# on a new server.
#
# Please note that this file does not include the WURFL PHP API. Please see
# install-wurfl-api.sh for more information about it.

script_dir="$(dirname "$(readlink -f ${BASH_SOURCE[0]})")"
install_dir="/var/mobile"

sudo mkdir ${install_dir}
sudo mkdir ${install_dir}/cache
sudo mkdir ${install_dir}/cache/img
sudo mkdir ${install_dir}/cache/wurfl
sudo mkdir ${install_dir}/cache/simplepie
sudo mkdir ${install_dir}/wurfl

sudo mkdir ${install_dir}/temp

sudo chmod 755 ${install_dir}/cache/img
sudo chmod 755 ${install_dir}/cache/wurfl
sudo chmod 755 ${install_dir}/cache/simplepie

sudo chown apache.apache ${install_dir}/cache/img
sudo chown apache.apache ${install_dir}/cache/wurfl
sudo chown apache.apache ${install_dir}/cache/simplepie

sudo cp -a ${script_dir}/components/wurfl-config.xml ${install_dir}/wurfl/wurfl-config.xml
sudo cp -a ${script_dir}/components/wurfl-web_browsers_patch.xml ${install_dir}/wurfl/wurfl-web_browsers_patch.xml
sudo wget -P ${install_dir}/temp/ http://sourceforge.net/projects/wurfl/files/WURFL/latest/wurfl-latest.xml.gz/download
sudo gunzip -c ${install_dir}/temp/wurfl-latest.xml.gz | sudo tee ${install_dir}/temp/wurfl-latest.xml > /dev/null
sudo mv ${install_dir}/temp/wurfl-latest.xml ${install_dir}/wurfl/wurfl.xml

sudo rm -rf ${install_dir}/temp
