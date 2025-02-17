# Usar imagem base do PHP 7.4 CLI
FROM php:7.4-cli

# Instalar dependências para o Composer
RUN apt-get update && apt-get install -y \
    git \
    unzip

# Baixar o Composer e salvar o arquivo composer.phar
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Definir o diretório de trabalho
WORKDIR /app

# Copiar o código para dentro do container
COPY . /app

# Instalar as dependências do Composer (executando no modo offline se necessário)
RUN COMPOSER_DISABLE_NETWORK=1 composer install --no-dev --optimize-autoloader

# Rodar o comando dump-autoload (sempre que precisar atualizar autoload manualmente)
RUN composer dump-autoload --optimize

# Rodar o PHP script
CMD ["php", "main.php"]
