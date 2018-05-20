<?php

namespace Test;

use bemang\Config;

class ConfigTest extends \PHPUnit\Framework\TestCase
{
    
    public function testDefineWithOnedValue()
    {
        $this->expectExceptionMessage('Valeur invalide lors du define');
        Config::define('bonjour');
    }

    public function testDefineWithInvalidParameters()
    {
        $this->expectExceptionMessage('$key doit être un fichier ou un tableau, 
            ou $key doit être une chaine de caractères avec l\'argument $value non vide');
        Config::define(123, 'salut');
    }

    public function testDefine()
    {
        Config::define('test1', 'salut');
        Config::define('test2', 'writing test');
        Config::define(['test3' => 'Les tests marchent ?', 'test4' => 'phpunit it is cool for writing tests']);
        $this->assertEquals([
            'test1' => 'salut',
            'test2' => 'writing test',
            'test3' => 'Les tests marchent ?',
            'test4' => 'phpunit it is cool for writing tests',
        ], Config::getDefinitions());
    }

    public function testGetWithNonString()
    {
        $this->expectExceptionMessage('La clé ' . 123 . ' est invalide');
        Config::get(123);
        Config::get(['test1', 'test2']);
    }

    public function testGetWithNotDefinedKey(Type $var = null)
    {
        $key = md5(uniqid());
        $this->expectExceptionMessage('La clé ' . $key . ' n\'est pas définie');
        Config::get($key);
    }

    public function testGet()
    {
        $this->assertEquals('salut', Config::get('test1'));
    }

    public function testHasWithEmptyKey()
    {
        $this->expectExceptionMessage('Une clé vide ne peut pas être vérifiée');
        Config::has('');
    }

    public function testDeleteWithEmptyKey()
    {
        $this->expectExceptionMessage('Une clé vide ne peut pas être supprimée');
        Config::delete('');
    }
}
