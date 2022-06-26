<?php

namespace bemang;

/**
 * Class permettant de faire une configuration simple
 * @see ConfigInterface::class Documentation
 */
class Config implements ConfigInterface
{
    /**
     * @var array
     */
    protected array $definitions = [];

    private static $selfInstance;

    /**
     * @param array|null $baseConfig
     * @throws ConfigException
     * @throws InvalidArgumentExceptionConfig
     */
    public function __construct(array $baseConfig = null)
    {
        if (!is_null($baseConfig)) {
            $this->define($baseConfig);
        }
    }

    /**
     * Récupère une l'instance courante (ne change pas)
     *
     * @return Config
     */
    public static function getInstance(): Config
    {
        if (is_null(Config::$selfInstance) || !Config::$selfInstance instanceof Config) {
            Config::$selfInstance = new Config();
        }
        return Config::$selfInstance;
    }

    /**
     * Récupère une instance vide de Config
     *
     * @param array|null $baseConfig
     * @return Config
     * @throws ConfigException
     * @throws InvalidArgumentExceptionConfig
     */
    public static function getEmptyInstance(array $baseConfig = null): Config
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
    public function getDefinitions(): array
    {
        return $this->definitions;
    }

    /**
     * @param $key
     * @return mixed
     * @throws ConfigException
     * @throws InvalidArgumentExceptionConfig
     */
    public function get($key): mixed
    {
        if (!empty($key) && is_string($key)) {
            if ($this->has($key)) {
                return $this->definitions[$key];
            } else {
                throw new ConfigException('La clé ' . $key . ' n\'est pas définie');
            }
        } else {
            throw new InvalidArgumentExceptionConfig('La clé ' . $key . ' est invalide');
        }
    }

    /**
     * @param $key
     * @param $value
     * @return bool
     * @throws ConfigException
     * @throws InvalidArgumentExceptionConfig
     */
    public function define($key, $value = null): bool
    {
        if ($value === null) {
            if (is_array($key)) {
                if ($this->arrayIsValidForConfig($key) === true) {
                    $this->definitions = array_merge($this->definitions, $key);
                    return true;
                } else {
                    throw new ConfigException('Le tableau est invalide pour la configuration');
                }
            } else {
                throw new InvalidArgumentExceptionConfig('Valeur invalide lors du define');
            }
        } elseif (is_string($key) && !empty($value)) {
            $this->definitions[$key] = $value;
            return true;
        } else {
            throw new InvalidArgumentExceptionConfig('$key invalide (array ou string obligatoire)');
        }
    }

    /**
     * @param $key
     * @return bool
     * @throws InvalidArgumentExceptionConfig
     */
    public function has($key): bool
    {
        if (!empty($key)) {
            $key = (string) $key;
            return !empty($this->definitions[$key]);
        } else {
            throw new InvalidArgumentExceptionConfig('Une clé vide ne peut pas être vérifiée');
        }
    }

    /**
     * @param $key
     * @return bool
     * @throws ConfigException
     * @throws InvalidArgumentExceptionConfig
     */
    public function delete($key): bool
    {
        if (!empty($key)) {
            if ($this->has($key)) {
                unset($this->definitions[$key]);
                return true;
            } else {
                throw new ConfigException('La clé ' . $key . 'n\'est pas définie');
            }
        } else {
            throw new InvalidArgumentExceptionConfig('Une clé vide ne peut pas être supprimée');
        }
    }

    /**
     * @param array $array
     * @return bool
     */
    public function arrayIsValidForConfig(array $array): bool
    {
        $valid = true;
        foreach ($array as $key => $value) {
            if (!is_string($key)) {
                $valid = false;
            }
        }
        return $valid;
    }
}
