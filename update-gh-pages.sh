#if [ "$TRAVIS_PULL_REQUEST" == "false" ]; then
    echo -e "Starting to update gh-pages\n"
    #copy data we're interested in to other place
    #cp -R target/phpdoc $HOME/api
    #ls -la $HOME/api
    #go to home and setup git
    cd $HOME
    git config --global user.email "actions@github.com"
    git config --global user.name "Github Actions"
    #using token clone gh-pages branch
    git clone --quiet --branch=gh-pages https://${GITHUB_TOKEN}@github.com/localgod/Karla.git gh-pages > /dev/null
    #go into diractory and copy data we're interested in to that directory
    cd gh-pages
    #api
    #rm -rf api
    #cp -Rf $HOME/api api
    #coverage
    rm -rf coverage
    cp -Rf $HOME/coverage coverage
    #add, commit and push files
    git add -f .
    git commit -m "Github build ${GITHUB_RUN_ID} pushed to gh-pages"
    git push -fq origin gh-pages > /dev/null
    echo -e "Updated coverage\n"
#fi