<?php

namespace bemang;

/**
 * Class permettant de faire une configuration simple
 * @see ConfigInterface::class Documentation
 */
class Config implements ConfigInterface
{
    protected $definitions = [];
    protected static $selfInstance;

    public function __construct(array $baseConfig = null)
    {
        if (!is_null($baseConfig)) {
            $this->define($baseConfig);
        }
    }

    public static function getInstance() :Config
    {
        if (is_null(Config::$selfInstance) || !Config::$selfInstance instanceof Config) {
            Config::$selfInstance = new Config();
        }
        return Config::$selfInstance;
    }

    /**
     * Récupère une instance vide de Coonfig
     *
     * @return Config
     */
    public static function getEmptyInstance(array $baseConfig = null) :Config
    {
        if (!is_null($baseConfig)) {
            $config = new Config($baseConfig);
        } else {
            $config = new Config();
        }
        return $config;
    }

    /**
     * Récupère toutes les définitions de la configuration
     *
     * @return array
     */
    public function getDefinitions() :array
    {
        return $this->definitions;
    }
    
    public function get($key)
    {
        if (!empty($key) && is_string($key)) {
            if (Config::has($key)) {
                return $this->definitions[$key];
            } else {
                throw new ConfigException('La clé ' . $key . ' n\'est pas définie');
            }
        } else {
            throw new InvalidArgumentExceptionConfig('La clé ' . $key . ' est invalide');
        }
    }

    public function define($key, $value = null) :bool
    {
        if ($value === null) {
            if (is_array($key)) {
                if ($this->arrayIsValidForConfig($key) === true) {
                    $this->definitions = array_merge($this->definitions, $key);
                    return true;
                } else {
                    throw new ConfigException('Le tableau est invalide pour la configuration');
                    return false;
                }
            } else {
                throw new InvalidArgumentExceptionConfig('Valeur invalide lors du define');
                return false;
            }
        } elseif (is_string($key) && !empty($value)) {
            $this->definitions[$key] = $value;
            return true;
        } else {
            throw new InvalidArgumentExceptionConfig('$key doit être un fichier ou un tableau, 
            ou $key doit être une chaine de caractères avec l\'argument $value non vide');
            return false;
        }
    }

    public function has($key) :bool
    {
        if (!empty($key)) {
            $key = (string) $key;
            return !empty($this->definitions[$key]);
        } else {
            throw new InvalidArgumentExceptionConfig('Une clé vide ne peut pas être vérifiée');
            return false;
        }
    }

    public function delete($key) :bool
    {
        if (!empty($key)) {
            if (Config::has($key)) {
                unset($this->definitions[$key]);
                return true;
            } else {
                throw new ConfigException('La clé ' . $key . 'n\'est pas définie');
                return false;
            }
        } else {
            throw new InvalidArgumentExceptionConfig('Une clé vide ne peut pas être supprimée');
            return false;
        }
    }

    public function arrayIsValidForConfig(array $array) :bool
    {
        $valid = true;
        foreach ($array as $key => $value) {
            if (!is_string($key) || empty($array[$key])) {
                $valid = false;
            }
        }
        return $valid;
    }
}
