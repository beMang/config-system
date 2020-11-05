<?php

namespace Test;

use \bemang\Config;

class ConfigTest extends \PHPUnit\Framework\TestCase
{
    protected $configInstance;

    public function setUp() :void
    {
        require_once(__DIR__ . '/../vendor/autoload.php');
        $this->configInstance = Config::getInstance();
    }

    public function testGetInstance()
    {
        $this->configInstance = Config::getInstance();
        $this->assertInstanceOf(Config::class, $this->configInstance);
    }

    public function testConstructWithBaseConfig()
    {
        $array = [
            'test1' => '123',
            'test2' => 'hello'
        ];
        $config = new Config($array);
        $this->assertEquals($array, $config->getDefinitions());
    }

    public function testGetEmptyInstance()
    {
        $instance = Config::getEmptyInstance();
        $this->assertEmpty($instance->getDefinitions());
        $array = [
            'test1' => '123',
            'test2' => 'hello'
        ];
        $config = Config::getEmptyInstance($array);
        $this->assertEquals($array, $config->getDefinitions());
    }

    public function testDefineWithOnedValue()
    {
        $this->expectExceptionMessage('Valeur invalide lors du define');
        $this->configInstance->define('bonjour');
    }

    public function testDefineWithInvalidParameters()
    {
        $this->expectExceptionMessage('$key invalide (array ou string obligatoire)');
        $this->configInstance->define(123, 'salut');
    }

    public function testDefineWithInvalidArray()
    {
        $array = [
            123 => ['hello'],
            'hello' => 123,
        ];
        $this->expectExceptionMessage('Le tableau est invalide pour la configuration');
        $this->configInstance->define($array);
    }

    public function testDefine()
    {
        $this->configInstance->define('test1', 'salut');
        $this->configInstance->define('test2', 'writing test');
        $this->configInstance->define([
            'test3' => 'Les tests marchent ?',
            'test4' => 'phpunit it is cool for writing tests'
        ]);
        $this->assertEquals([
            'test1' => 'salut',
            'test2' => 'writing test',
            'test3' => 'Les tests marchent ?',
            'test4' => 'phpunit it is cool for writing tests',
        ], $this->configInstance->getDefinitions());
    }

    public function testGetWithNonString()
    {
        $this->expectExceptionMessage('La clé ' . 123 . ' est invalide');
        $this->configInstance->get(123);
        $this->configInstance->get(['test1', 'test2']);
    }

    public function testGetWithNotDefinedKey(Type $var = null)
    {
        $key = md5(uniqid());
        $this->expectExceptionMessage('La clé ' . $key . ' n\'est pas définie');
        $this->configInstance->get($key);
    }

    public function testGet()
    {
        $this->assertEquals('salut', $this->configInstance->get('test1'));
    }

    public function testHasWithEmptyKey()
    {
        $this->expectExceptionMessage('Une clé vide ne peut pas être vérifiée');
        $this->configInstance->has('');
    }

    public function testDeleteWithEmptyKey()
    {
        $this->expectExceptionMessage('Une clé vide ne peut pas être supprimée');
        $this->configInstance->delete('');
    }

    public function testDeleteNotDefinedKey()
    {
        $key = uniqid();
        $this->expectExceptionMessage('La clé ' . $key . 'n\'est pas définie');
        $this->configInstance->delete($key);
    }

    public function testDelete()
    {
        $this->configInstance->delete('test2');
        $this->assertArrayNotHasKey('test2', $this->configInstance->getDefinitions());
    }
}
