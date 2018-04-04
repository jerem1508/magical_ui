# magical_ui
## APACHE
```
sudo apt-get install apache2
```
## PHP
```
sudo apt-get install php
sudo apt-get install libapache2-mod-php7.0
```
### CUrl module
```
sudo apt-get install php-curl
```
## Database
### MySQL
```
sudo apt-get install mysql-server
mysql -u root -p
exit ;
```

### PHPMyAdmin
```
sudo apt install phpmyadmin
sudo gedit /etc/apache2/apache2.conf
	Include /etc/phpmyadmin/apache.conf
sudo /etc/init.d/apache2 restart

Access : http://localhost/phpmyadmin
```
### First script
```
mysql -u root -p magical_ui < init.sql
```
