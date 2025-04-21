#!/bin/bash

# Verifica se o arquivo .env já existe
if [ ! -f /var/www/html/.env ]; then
  echo "Copiando .env.example para .env..."
  cp /var/www/html/.env.example /var/www/html/.env
fi

# Carrega as variáveis de ambiente do arquivo .env
export $(grep -v '^#' .env | xargs)

# Instala as dependências do Composer
echo "Instalando dependências do Composer..."
composer install

# Inicia o servidor PHP
echo "Iniciando o servidor PHP..."
php -S 0.0.0.0:80 -t public &

# Aguarda o servidor ser iniciado e o banco de dados ficar disponível
sleep 10

echo -e "\033[1;42;37m\033[5m####################################################################\033[0m"
echo -e "\033[1;42;37m\033[5mAplicação iniciada e pronta para uso em http://localhost:${APP_PORT}\033[0m"
echo -e "\033[1;42;37m\033[5m####################################################################\033[0m"

# Mantém o container ativo
tail -f /dev/null
