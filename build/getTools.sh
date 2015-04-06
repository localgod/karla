#!/usr/bin/env sh
CWD=`pwd`

DIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )

#Go to the correct path
cd $DIR

if [ ! -f ./tools ]; then
mkdir ./tools
fi

#php copy paste detection
wget -nc -O ./tools/phpcpd.phar --no-check-certificate https://phar.phpunit.de/phpcpd.phar
chmod 755 ./tools/phpcpd.phar

#php lines of code
wget -nc -O ./tools/phploc.phar --no-check-certificate wget https://phar.phpunit.de/phploc.phar
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

#composer dependency management
curl -sS https://getcomposer.org/installer | php
mv composer.phar ../

#back to where we started the script
cd $CWD
