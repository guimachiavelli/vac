sudo apt-get update

sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password root'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root'
sudo apt-get install -y mysql-server mysql-client

sudo apt-get install -y apache2 curl

sudo apt-get install -y php5 libapache2-mod-php5 php5-curl php5-gd php5-mysql php5-xdebug

cat > /etc/apache2/sites-available/vac.conf <<VHOST
<VirtualHost *:80>
    DocumentRoot /site
    ServerName 127.0.0.1
    ServerAlias localhost
    <Directory /site>
        Options Indexes FollowSymLinks MultiViews
        AllowOverride All
        EnableSendfile off
    </Directory>
</VirtualHost>
VHOST

sudo a2enmod rewrite
sudo a2dissite default
sudo a2ensite vac.conf

sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php5/apache2/php.ini
sed -i "s/display_errors = .*/display_errors = On/" /etc/php5/apache2/php.ini

sudo service apache2 restart

mysql -u root -proot -e "CREATE DATABASE IF NOT EXISTS vac_db;"
