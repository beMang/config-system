# Système de configuration PHP
[![Build Status](https://travis-ci.org/beMang/Config-System.svg?branch=master)](https://travis-ci.org/beMang/Config-System)  [![Coverage Status](https://coveralls.io/repos/github/beMang/Config-System/badge.svg?branch=master)](https://coveralls.io/github/beMang/Config-System?branch=master)

## Installation
Need composer

```composer require bemang/config-system```

```php
require('vendor/autoload.php');
```

## Usage
```php
    use bemang\Config;
    $config = Config::getInstance(); //For get single instance
    $config->define('test', 'hello'); //For define key
    $config->get('test'); //For get key

    $config->define([
        'test' => 123,
        'test3' => ['Jean', 'Yves']
    ]); //Define multiple key

    $config->has('test'); //Verify a key

    $config->delete('test'); //Delete a key
```

## TODO
* Tous mettre en statique pour ne plus avoir à créer l'instance à chaque fois
* Pour une version 2.0