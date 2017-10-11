FROM php:7.0-apache

# RUN git clone https://github.com/jerem1508/magical_ui.git
COPY . /var/www/magical_ui
# RUN ln -s magical_ui /var/www

RUN apt-get update

RUN apt-get install debconf-utils
RUN echo 'mysql-server mysql-server/root_password password l4ndry!' | debconf-set-selections
RUN echo 'mysql-server mysql-server/root_password_again password l4ndry!' | debconf-set-selections
RUN apt-get -y install mysql-server

# RUN a2enmod php7.0
# RUN echo "Include /etc/phpmyadmin/apache.conf" | cat >> /etc/apache2/apache2.conf

EXPOSE 80
COPY /conf/magical_ui.conf /etc/apache2/sites-available/
RUN rm /etc/apache2/sites-enabled/*.conf
RUN ln -s /etc/apache2/sites-available/magical_ui.conf /etc/apache2/sites-enabled/magical_ui.conf

WORKDIR /var/www/magical_ui
RUN /etc/init.d/apache2 restart
