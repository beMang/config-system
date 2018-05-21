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

    public static function getInstance()
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
    public static function getEmptyInstance()
    {
        return new Config();
    }

    /**
     * Récupère toutes les définitions de la configuration
     *
     * @return array
     */
    public function getDefinitions()
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

    public function define($key, $value = null)
    {
        if ($value === null) {
            if (is_array($key)) {
                $this->definitions = array_merge($this->definitions, $key);
            } else {
                throw new InvalidArgumentExceptionConfig('Valeur invalide lors du define');
            }
        } elseif (is_string($key) && !empty($value)) {
            $this->definitions[$key] = $value;
        } else {
            throw new InvalidArgumentExceptionConfig('$key doit être un fichier ou un tableau, 
            ou $key doit être une chaine de caractères avec l\'argument $value non vide');
        }
    }

    public function has($key)
    {
        if (!empty($key)) {
            $key = (string) $key;
            return !empty($this->definitions[$key]);
        } else {
            throw new InvalidArgumentExceptionConfig('Une clé vide ne peut pas être vérifiée');
        }
    }

    public function delete($key)
    {
        if (!empty($key)) {
            if (Config::has($key)) {
                unset($this->definitions[$key]);
            } else {
                throw new ConfigException('La clé ' . $key . 'n\'est pas définie');
            }
        } else {
            throw new InvalidArgumentExceptionConfig('Une clé vide ne peut pas être supprimée');
        }
    }
}
