<?php

namespace bemang;

/**
 * Interface pour la création d'implémentation
 */
interface ConfigInterface
{
    /**
     * Récupère une instance (modèle single instance)
     *
     * @return Config
     */
    public static function getInstance(): Config;

    /**
     * Défini une clé sur la config
     *
     * @param string|array $key String pour le nom de la clé ou tableau associatif pour l'ajouter à la config
     * @param mixed $value Si $key est un string, $value est la valeur à associer à $key
     * @return bool
     */
    public function define(string|array $key, mixed $value): bool;

    /**
     * Récupère une clé
     *
     * @param string $key Clé à récupérer
     * @return mixed Résultat du get (peut être une erreur)
     */
    public function get(string $key): mixed;

    /**
     * Vérifie si une clé existe
     *
     * @param string $key Clé à vérifier
     * @return boolean
     */
    public function has(string $key): bool;

    /**
     * Supprime une clé
     *
     * @param string $key Clé à supprimer
     * @return bool Résultat
     */
    public function delete(string $key): bool;
}
