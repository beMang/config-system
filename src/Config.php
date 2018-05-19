<?php

namespace bemang;

class Config implements ConfigInterface
{
    protected static $definitions = [];

    public static function get($key)
    {
        if (!empty($key) && is_string($key)) {
            if (Config::has($key)) {
                return Config::$definitions[$key];
            } else {
                throw new ConfigException('La clé ' . $key . ' n\'est pas définie');
            }
        } else {
            throw new InvalidArgumentExceptionConfig('La clé ' . $key . ' est invalide');
        }
    }

    public static function define($key, $value = null)
    {
        if ($value === null) {
            if (is_array($key)) {
                Config::$definitions = array_merge(Config::$definitions, $key);
            } else {
                throw new InvalidArgumentExceptionConfig('Valeur invalide lors du define');
            }
        } elseif (is_string($key) && !empty($value)) {
            Config::$definitions[$key] = $value;
        } else {
            throw new InvalidArgumentExceptionConfig('$key doit être un fichier ou un tableau, 
            ou $key doit être une chaine de caractères avec l\'argument $value non vide');
        }
    }

    public static function has($key)
    {
        if (!empty($key)) {
            return !empty(Config::$definitions[$key]);
        } else {
            throw new InvalidArgumentExceptionConfig('Une clé vide ne peut pas être vérifiée (' . $key . ')');
        }
    }

    public static function delete($key)
    {
        if (!empty($key)) {
            if (Config::$has($key)) {
                unset(Config::$definitions[$key]);
            } else {
                throw new ConfigException('La clé ' . $key . 'n\'est pas définie');
            }
        } else {
            throw new InvalidArgumentExceptionConfig('Une clé vide ne peut pas être supprimée (' . $key . ')');
        }
    }
}
