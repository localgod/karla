# Contribute

Karla is easy to extend and contributions are hughly appreciated.

Before you make a pull request make sure all tests still run and, if you have added functionality, that appropriate tests has been added. 

## Testing

Karla is currently tested with version 5.3, 5.4 and 5.5 of php.

Karla itself dos not depend on any third party libraries but its test suite dos.

To test Karla you need to get the relevant tools. 

Karla uses [Ant](http://ant.apache.org/) as build script so first step is to install Ant.

Next you need some php specific tools. The easiest way to get these is with [composer](https://getcomposer.org/)

Once installed run composer from the root of your karla checkout:
```
$ ./composer.phar install
``` 

This will, amoung some other tools, install [phpunit](http://phpunit.de/) and [behat](http://behat.org/)

You can now, via Ant, run the tests:
```
ant behat
ant phpunit
```

Once no test fails, you can check code coverage here: ./target/phpunit/coverage/index.html 

## Coding Standard

Karla is [PSR-2] (https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) compliant. 

Via Ant, you can check if the code you plan to push is compliant:
```
ant phpcs
``` 

This generates a report you can view in your browser: ./target/phpcs/checkstyle.html

Please keep pull requests compliant.

## Other tools

If you run Ant without any arguments you will get a list of possible targets.



