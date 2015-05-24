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

#Behat gherkin parser #not used as the current version do not work
wget -nc -O ./tools/behat.phar --no-check-certificate https://github.com/downloads/Behat/Behat/behat.phar
chmod 755 ./tools/behat.phar

#php dead code detection
wget -nc -O ./tools/phpdcd.phar --no-check-certificate https://phar.phpunit.de/phpdcd.phar
chmod 755 ./tools/phpdcd.phar

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

#php lines of code
wget -nc -O ./tools/phploc.phar --no-check-certificate https://phar.phpunit.de/phploc.phar
chmod 755 ./tools/phploc.phar

#php mess detection
wget -nc -O ./tools/phpmd.phar http://static.phpmd.org/php/1.5.0/phpmd.phar
chmod 755 ./tools/phpmd.phar

#php dependency detection
wget -nc -O ./tools/pdepend.phar http://static.pdepend.org/php/latest/pdepend.phar
chmod 755 ./tools/pdepend.phar

#Ant extension
if [ ! -f ./tools/ant-contrib-1.0b3.jar ]; then
wget -nc -O ./tools/ant-contrib-1.0b3-bin.zip http://sourceforge.net/projects/ant-contrib/files/ant-contrib/1.0b3/ant-contrib-1.0b3-bin.zip/download
unzip -p ./tools/ant-contrib-1.0b3-bin.zip ant-contrib/ant-contrib-1.0b3.jar > ./tools/ant-contrib-1.0b3.jar
rm -rf ./tools/ant-contrib-1.0b3-bin.zip
fi

#back to where we started the script
cd $CWD