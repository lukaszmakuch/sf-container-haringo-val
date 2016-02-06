# SfContainerHaringoVal
Let Haringo use values from the Symfony DI container!

[![travis](https://travis-ci.org/lukaszmakuch/sf-container-haringo-val.svg)](https://travis-ci.org/lukaszmakuch/sf-container-haringo-val)

## Getting Symfony container Haringo value source extension
```
$ composer require lukaszmakuch/sf-container-haringo-val
```
## Building extension
```php
<?php
use lukaszmakuch\SfContainerHaringoVal\InjectedValueExtensionFactory;
use Symfony\Component\DependencyInjection\Container;

/* @var $symfonyContainer Container */
$extensionFactory = new InjectedValueExtensionFactory();
$extension = $extensionFactory->buildWith($symfonyContainer);
```

## Installing
For installation instruction check the main Haringo documentation.
