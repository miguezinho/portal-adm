#!/bin/bash

# Verifica se o arquivo .env já existe
if [ ! -f /var/www/html/.env ]; then
  echo "Copiando .env.example para .env..."
  cp /var/www/html/.env.example /var/www/html/.env
fi

# Instala as dependências do Composer
echo "Instalando dependências do Composer..."
composer install

# Inicia o servidor PHP
echo "Iniciando o servidor PHP..."
php -S 0.0.0.0:80 -t public

# Mantém o container ativo
tail -f /dev/null
