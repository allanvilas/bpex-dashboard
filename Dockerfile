# Usar a imagem oficial do PHP com Apache
FROM php:8.1-apache

# Instalar dependências necessárias e extensões do PHP
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    libicu-dev \
    && docker-php-ext-install zip pdo_mysql intl mysqli \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Habilitar mod_rewrite para o Apache
RUN a2enmod rewrite

# Copiar o arquivo de configuração do Apache
COPY app/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Ativar o Virtual Host
RUN a2ensite 000-default.conf

# Configurar o diretório de trabalho
WORKDIR /var/www/html

# Copiar os arquivos do projeto para o contêiner
COPY . /var/www/html

# Configurar permissões apropriadas
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/writable \
    && chmod -R 775 /var/www/html/writable/cache

# Resolver o problema de segurança do repositório git
RUN git config --global --add safe.directory /var/www/html

# Instalar o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Executar o Composer para instalar dependências
RUN composer install --no-dev --optimize-autoloader

# Expor a porta do Apache
EXPOSE 80

# Definir a variável de ambiente
ENV CI_ENVIRONMENT=development

# Comando para iniciar o Apache
CMD ["apache2-foreground"]
