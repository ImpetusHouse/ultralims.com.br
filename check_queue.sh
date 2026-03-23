#!/bin/bash

# Diretório onde o comando deve ser executado
WORKDIR="/home/ultrasite/domains/ultralims.com.br/public_html"
# Caminho completo para o PHP
PHP_PATH="/usr/local/php83/bin/php"
# Nome do processo para verificar
PROCESS="php artisan queue:work"
# Arquivo de log para registrar a execução
LOGFILE="$WORKDIR/storage/logs/queue.log"

# Entrar no diretório de trabalho
cd "$WORKDIR" || { echo "Erro: Não foi possível acessar o diretório $WORKDIR"; exit 1; }

# Verificar se o processo está em execução
if pgrep -f "$PROCESS" > /dev/null
then
    echo "O processo da fila já está em execução."
else
    echo "O processo da fila não está em execução. Iniciando..."
    nohup $PHP_PATH artisan queue:work > "$LOGFILE" 2>&1 &
    echo "Processo iniciado."
fi

