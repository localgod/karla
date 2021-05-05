clean:
	if [ -f ./junit.xml ] ; then rm ./junit.xml; fi
	if [ -f ./clover.xml ] ; then rm ./clover.xml; fi
	if [ -d ./html-coverage ] ; then rm -r ./coverage; fi

style:
	./bin/phpcs

unit:
	./bin/phpunit --configuration ./tests/unit/phpunit.xml

integration:
	./bin/behat

publish:
#	if [ -d ./gh-pages ] ; then rm -rf ./gh-pages; fi
#	git clone --quiet --branch=gh-pages https://${GITHUB_TOKEN}@github.com/localgod/Karla.git gh-pages > /dev/null
	if [ -d ./gh-pages/coverage ] ; then rm -rf ./gh-pages/coverage; fi
	cp -Rf ./coverage ./gh-pages/
	cd ./gh-pages/
	git add -f .
	git commit -m "Github build ${GITHUB_RUN_ID} pushed to gh-pages"
	git push -fq origin gh-pages > /dev/null
	cd ..