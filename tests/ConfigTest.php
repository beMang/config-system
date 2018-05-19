<?php

namespace Test;

use bemang\Config;

class ConfigTest extends \PHPUnit\Framework\TestCase
{
    
    public function testDefine()
    {
        $this->expectExceptionMessage('Valeur invalide lors du define');
        Config::define('bonjour');
        $this->expectExceptionMessage('$key doit être un fichier ou un tableau, 
            ou $key doit être une chaine de caractères avec l\'argument $value non vide');
        Config::define(123, 'salut');
        Config::define('test1', 'salut');
        Config::define('test2', 'writing test');
        Config::define(['test3' => 'Les tests marchent ?', 'test4' => 'phpunit it is cool for writing tests']);
    }

    public function testGet()
    {
        $this->expectExceptionMessage('La clé ' . 123 . ' est invalide');
        Config::get(123);
        Config::get(['test1', 'test2']);
        $key = md5(uniqid());
        $this->expectExceptionMessage('La clé ' . $key . ' n\'est pas définie');
        Config::get($key);
        Config::get('test1');
    }
}
