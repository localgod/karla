#!/usr/bin/env sh
CWD=`pwd`

DIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )

#Go to the correct path
cd $DIR

#composer dependency management
curl -sS https://getcomposer.org/installer | php
mv composer.phar ../

if [ ! -f ./tools ]; then
mkdir ./tools
fi

#php copy paste detection
wget -nc -O ./tools/phpcpd.phar --no-check-certificate https://phar.phpunit.de/phpcpd.phar
chmod 755 ./tools/phpcpd.phar

#php checkstyle
wget -nc -O ./tools/phpcs.phar --no-check-certificate https://squizlabs.github.io/PHP_CodeSniffer/phpcs.phar
chmod 755 ./tools/phpcs.phar

#php code browser
wget -nc -O ./tools/phpcb.phar --no-check-certificate https://github.com/mayflower/PHP_CodeBrowser/releases/download/1.1.1/phpcb-1.1.1.phar
chmod 755 ./tools/phpcb.phar

#phpDocumentor
wget -nc -O ./tools/phpDocumentor.phar http://www.phpdoc.org/phpDocumentor.phar
chmod 755 ./tools/phpDocumentor.phar

#phpunit
wget -nc -O ./tools/phpunit.phar --no-check-certificate https://phar.phpunit.de/phpunit.phar
chmod 755 ./tools/phpunit.phar
