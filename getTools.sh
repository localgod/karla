#!/usr/bin/env sh
CWD=`pwd`

DIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )

#phpDocumentor
wget -nc -O ./phpDocumentor --no-check-certificate https://phpdoc.org/phpDocumentor.phar
chmod 755 ./phpDocumentor
