FROM anthonykgross/docker-base:latest

MAINTAINER Anthony K GROSS

WORKDIR /var/www/html

# PHP7 NGINX...
RUN curl https://www.dotdeb.org/dotdeb.gpg | apt-key add - && \
    echo 'deb http://packages.dotdeb.org jessie all' >> /etc/apt/sources.list && \
    apt-get update -y && \
	apt-get upgrade -y && \
	apt-get install -y curl nginx git supervisor php7.0-fpm php7.0-zip php7.0-mysql php7.0-opcache php7.0-xml
RUN	rm -Rf /etc/nginx/* && \
    mkdir -p /etc/nginx/sites-enabled

# Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
	php -r "if (hash_file('SHA384', 'composer-setup.php') === '669656bab3166a7aff8a7506b8cb2d1c292f042046c5a994c43155c0be6190fa0355160742ab2e1c88d40d5be660b410') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
	php composer-setup.php && \
	php -r "unlink('composer-setup.php');" && \
	mv composer.phar /usr/bin/composer && \
	chmod +x /usr/bin/composer

# Node.js
RUN curl -sL https://deb.nodesource.com/setup_6.x | bash - && \
	apt-get install nodejs

# Yarn
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - && \
    echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list && \
    apt-get update -y && \
    apt-get install -y yarn
RUN yarn global add @angular/cli && \
    ng set --global packageManager=yarn && \
    ng set --global warnings.versionMismatch=false

ADD entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh && \
	rm /var/www/html/index.nginx-debian.html && \
	echo "user = docker" >> /etc/php/7.0/fpm/pool.d/www.conf

RUN rm -rf /var/lib/apt/lists/* && apt-get autoremove -y --purge

EXPOSE 80
EXPOSE 443

ENV  APP_ENV prod

ENTRYPOINT ["/entrypoint.sh"]
CMD ["run"]
