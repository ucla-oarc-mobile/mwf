# The MWF includes an adapter for device interpretation that connects to the
# WURFL PHP API. However, because of different license restrictions, it must be
# downloaded separately, and end users are responsible for complying with its
# license requirements.
#
# To download the most recent version of the WURFL PHP API under the AGPL or a
# Commericial license, please see the following URL:
#
#       http://sourceforge.net/projects/wurfl/files/WURFL%20PHP/
#
# For your convinience, an old version of the WURFL PHP API under the GNU/GPL 2
# is also still available here:
#
#       http://mwf.ucla.edu/wurfl-php-api-1.2.1.tgz
#
# To download the most recent version, please see the Sourceforge site. However,
# if you instead need to run the older version under the GNU/GPL 2, it can be
# downloaded with the following commands:

install_dir="/var/mobile"

sudo mkdir ${install_dir}/temp

sudo wget -P ${install_dir}/temp/ http://mwf.ucla.edu/wurfl-php-api-1.2.1.tgz
sudo tar -xvzf ${install_dir}/temp/wurfl-php-api-1.2.1.tgz
sudo mkdir ${install_dir}/wurfl/
sudo mv api ${install_dir}/wurfl/

sudo rm -rf ${install_dir}/temp
