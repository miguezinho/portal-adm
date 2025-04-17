#!/bin/bash

# Variáveis padrão
DB_HOST=${DB_HOST:-localhost}
DB_USERNAME=${DB_USERNAME:-root}
DB_PASSWORD=${DB_PASSWORD:-secret}
DB_NAME=${DB_DATABASE:-portal_adm}

# Verifica se o banco de dados está acessível antes de executar o script SQL
echo "Aguardando MySQL estar disponível..."
until mysqladmin ping -h "$DB_HOST" -u"$DB_USERNAME" -p"$DB_PASSWORD" --silent; do
    sleep 1
done

# Executa o script DDL se o banco de dados estiver acessível
echo "Executando o script DDL..."
mysql -h "$DB_HOST" -u"$DB_USERNAME" -p"$DB_PASSWORD" "$DB_NAME" < /scripts/ddl.sql

echo "Script DDL executado com sucesso!"
