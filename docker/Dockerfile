# Fetch the latest Wordpress image
FROM wordpress:latest

# Install required packages
RUN apt-get update && \
    apt-get install -y unzip jq openssl && \
    rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js
RUN apt-get update && \
    apt-get install -y nodejs && \
    rm -rf /var/lib/apt/lists/*

# Enable Apache modules and sites
RUN a2enmod ssl && \
    a2enmod socache_shmcb && \
    a2ensite default-ssl

# Copy SSL certificates and configure Apache SSL
COPY docker/ssl/*.crt /etc/ssl/certs/server.crt
COPY docker/ssl/*.key /etc/ssl/private/server.key
RUN sed -i '/SSLCertificateFile.*snakeoil\.pem/c\SSLCertificateFile \/etc\/ssl\/certs\/server.crt' /etc/apache2/sites-available/default-ssl.conf
RUN sed -i '/SSLCertificateKeyFile.*snakeoil\.key/c\SSLCertificateKeyFile \/etc\/ssl\/private\/server.key' /etc/apache2/sites-available/default-ssl.conf
