clean:
	if [ -f ./junit.xml ] ; then rm ./junit.xml; fi
	if [ -f ./clover.xml ] ; then rm ./clover.xml; fi
	if [ -d ./html-coverage ] ; then rm -r ./html-coverage; fi

style:
	./bin/phpcs

unit:
	./bin/phpunit --configuration ./tests/unit/phpunit.xml

integration:
	./bin/behat	