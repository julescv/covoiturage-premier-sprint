<?php

// Récupère le code commun d'inscription en base
function obtenirCodeInscription(PDO $connexion): ?string
{
    try {
        $requete = $connexion->query('SELECT code FROM parametres ORDER BY rowid DESC LIMIT 1');
        $ligne = $requete->fetch();

        if (!$ligne || !isset($ligne['code']) || trim((string) $ligne['code']) === '') {
            return null;
        }

        return trim((string) $ligne['code']);
    } catch (Throwable) {
        return null;
    }
}

// Définit ou met à jour le code commun d'inscription
function definirCodeInscription(PDO $connexion, string $code): void
{
    $requete = $connexion->query('SELECT COUNT(*) FROM parametres');
    $existe = (int) $requete->fetchColumn() > 0;

    if ($existe) {
        $miseAJour = $connexion->prepare('UPDATE parametres SET code = :code');
        $miseAJour->execute([':code' => $code]);
    } else {
        $insertion = $connexion->prepare('INSERT INTO parametres (code) VALUES (:code)');
        $insertion->execute([':code' => $code]);
    }
}
