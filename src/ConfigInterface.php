<?php

namespace bemang;

/**
 * Interface pour la création d'implémentation personalisée
 */
interface ConfigInterface
{
    /**
     * Récupère une instance (Pattern single instance)
     *
     * @return Config
     */
    public static function getInstance();

    /**
     * Défini une clé sur la config
     *
     * @param string|array $key String pour le nom de la clé ou tableau associatif pour l'ajouter à la config
     * @param mixin $value Si $key est un string, $value est la valeur à associer )à $key
     * @return InvalidArgumentExceptionConfig|void
     */
    public function define($key, $value = null);

    /**
     * Récupère une clé
     *
     * @param string $key Clé à récupérer
     * @return mixin Résultat du get (peut être une erreur)
     */
    public function get($key);

    /**
     * Vérifie si une clé existe
     *
     * @param string $key Clé à vérifier
     * @return boolean
     */
    public function has($key);

    /**
     * Supprime une clé
     *
     * @param string $key Clé à supprimer
     * @return void|ConfigException|InvalidArgumentExceptionConfig Résultat
     */
    public function delete($key);
}
