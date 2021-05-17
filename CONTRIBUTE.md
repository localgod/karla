# Contribute

Karla is easy to extend and contributions are hughly appreciated.

Before you make a pull request make sure all tests still run and, if you have added functionality, that appropriate tests has been added. 

## Testing

Karla is currently tested with version 8.0 of php.

Karla itself does not depend on any third party libraries but its test suite does.

To test Karla you need to get the relevant tools. 

You need some php specific tools. The easiest way to get these is with [composer](https://getcomposer.org/)

Once installed run composer from the root of your karla checkout:
```
$ composer install
``` 

This will, amoung some other tools, install [phpunit](http://phpunit.de/) and [behat](http://behat.org/)

You can now, run the tests:
```
composer run unit
composer run integration
```

Once no test fails, you can check code coverage here: ./coverage/index.html 

## Coding Standard

Karla is [PSR-12] (https://www.php-fig.org/psr/psr-12/) compliant. 

You can check if the code you plan to push is compliant:
```
composer run cs
``` 

Please keep pull requests compliant.