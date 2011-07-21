script_dir="$(dirname "$(readlink -f ${BASH_SOURCE[0]})")"
install_dir="/var/mobile"

sudo mkdir ${install_dir}
sudo mkdir ${install_dir}/cache
sudo mkdir ${install_dir}/cache/img
sudo mkdir ${install_dir}/cache/wurfl
sudo mkdir ${install_dir}/cache/magpierss
sudo mkdir ${install_dir}/wurfl

sudo mkdir ${install_dir}/temp

sudo chmod 755 ${install_dir}/cache/img
sudo chmod 755 ${install_dir}/cache/wurfl
sudo chmod 755 ${install_dir}/cache/magpierss

sudo chown apache.apache ${install_dir}/cache/img
sudo chown apache.apache ${install_dir}/cache/wurfl
sudo chown apache.apache ${install_dir}/cache/magpierss

sudo cp -a ${script_dir}/components/wurfl-config.xml ${install_dir}/wurfl/wurfl-config.xml
sudo cp -a ${script_dir}/components/wurfl-web_browsers_patch.xml ${install_dir}/wurfl/wurfl-web_browsers_patch.xml
sudo wget -P ${install_dir}/temp/ http://sourceforge.net/projects/wurfl/files/WURFL/latest/wurfl-latest.xml.gz/download
sudo gunzip -c ${install_dir}/temp/wurfl-latest.xml.gz | sudo tee ${install_dir}/temp/wurfl-latest.xml > /dev/null
sudo mv ${install_dir}/temp/wurfl-latest.xml ${install_dir}/wurfl/wurfl.xml

sudo wget -P ${install_dir}/temp/ http://mwf.ucla.edu/wurfl-php-api-1.2.1.tgz
sudo tar -xvzf ${install_dir}/temp/wurfl-php-api-1.2.1.tgz
sudo mv api ${install_dir}/wurfl/

sudo rm -rf ${install_dir}/temp
