FROM wordpress:latest

# Install Composer
RUN curl -s https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

# Install Node and NPM
RUN curl -s https://deb.nodesource.com/setup_16.x | bash
RUN apt-get update
RUN apt-get install -y nodejs

# Install unzip to extract zip files
RUN apt-get install unzip

# Copy content folder
COPY docker/content/* /usr/src/wordpress/wp-content/
RUN unzip -o /usr/src/wordpress/wp-content/wp-content.zip -d /usr/src/wordpress/wp-content || true
RUN rm /usr/src/wordpress/wp-content/wp-content.zip || true

# Get elmgren-theme as default
ADD https://elmgrentheme.elmgren.dev/latest/elmgren-theme.zip /usr/src/wordpress/wp-content/themes/
RUN unzip -o /usr/src/wordpress/wp-content/themes/elmgren-theme.zip -d /usr/src/wordpress/wp-content/themes
RUN rm /usr/src/wordpress/wp-content/themes/elmgren-theme.zip

# Install SSL dependencies
RUN apt-get update && \
    apt-get install -y openssl && \
    a2enmod ssl && \
    a2enmod socache_shmcb && \
    a2ensite default-ssl && \
    rm -rf /var/lib/apt/lists/*

# Generate SSL certificate and key
COPY docker/ssl/*.crt /etc/ssl/certs/server.crt
COPY docker/ssl/*.key /etc/ssl/private/server.key

RUN sed -i '/SSLCertificateFile.*snakeoil\.pem/c\SSLCertificateFile \/etc\/ssl\/certs\/server.crt' /etc/apache2/sites-available/default-ssl.conf
RUN sed -i '/SSLCertificateKeyFile.*snakeoil\.key/c\SSLCertificateKeyFile \/etc\/ssl\/private\/server.key' /etc/apache2/sites-available/default-ssl.conf
RUN echo "tillfest.local" > /etc/hostname