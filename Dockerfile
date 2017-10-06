FROM php:7.0-apache
#FROM bylexus:apache-php7

#RUN git clone https://github.com/jerem1508/magical_ui.git
#COPY ./ /var/www/
RUN ln -s . /var/www/magical_ui

RUN apt-get update
RUN apt-get --assume-yes install mysql-server phpmyadmin
RUN mysql -u root -p && exit;

RUN apt-get --assume-yes install libapache2-mod-php php-curl
RUN a2enmod php7.0
RUN echo "Include /etc/phpmyadmin/apache.conf" | cat >> /etc/apache2/apache2.conf

COPY magical_ui/conf/magical_ui.conf /etc/apache2/sites-available/
RUN ln -s /etc/apache2/sites-available/magical_ui.conf /etc/apache2/sites-enabled/magical_ui.conf
RUN /etc/init.d/apache2 restart
