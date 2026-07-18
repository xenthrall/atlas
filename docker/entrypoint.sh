#!/bin/sh
set -e

echo "Esperando a que MySQL esté disponible en ${DB_HOST:-mysql}..."

MAX_TRIES=30
TRIES=0

until mysqladmin ping -h"${DB_HOST:-mysql}" -u"${DB_USERNAME}" -p"${DB_PASSWORD}" --ssl=0 --silent; do
  TRIES=$((TRIES + 1))
  if [ "$TRIES" -ge "$MAX_TRIES" ]; then
    echo "No se pudo conectar a MySQL después de ${MAX_TRIES} intentos. Abortando."
    echo "Verifica DB_HOST/DB_USERNAME/DB_PASSWORD y que el usuario tenga permisos."
    exit 1
  fi
  sleep 2
done

echo "MySQL disponible."

echo "Optimizando Laravel..."
php artisan optimize

echo "Ejecutando: $@"
exec "$@"