<?php

require_once __DIR__ . '/../View/view.php';
require_once __DIR__ . '/../Model/Repository/utilisateurRepository.php';

// Vérifie si l'utilisateur est connecté via sa session
function estConnecte(): bool
{
    if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
        session_start();
    }

    return isset($_SESSION['utilisateur'])
        && is_array($_SESSION['utilisateur'])
        && !empty($_SESSION['utilisateur']['id']);
}

// Renvoie les données de l'utilisateur connecté ou null
function obtenirUtilisateurConnecte(): ?array
{
    return estConnecte() ? $_SESSION['utilisateur'] : null;
}

// Bloque l'accès si non connecté et redirige vers la connexion
function exigerConnexion(): bool
{
    if (!estConnecte()) {
        afficherFormulaireConnexion([
            'Veuillez vous connecter pour accéder à cet espace.',
        ]);
        return false;
    }

    return true;
}

// Affiche la page de connexion
function afficherFormulaireConnexion(array $erreurs = [], string $email = ''): void
{
    afficherVue('connexion/formulaire', [
        'titre' => 'Se connecter — Covoiturage',
        'pageCourante' => 'connexion',
        'erreurs' => $erreurs,
        'email' => $email,
    ]);
}

// Traitement de la connexion
function traiterConnexion(PDO $connexion): void
{
    $email = trim((string) ($_POST['email'] ?? ''));
    $motDePasse = (string) ($_POST['mot_de_passe'] ?? '');

    $erreurs = [];

    // Vérification des champs requis
    if ($email === '') {
        $erreurs[] = 'L’adresse électronique est obligatoire.';
    }
    if (trim($motDePasse) === '') {
        $erreurs[] = 'Le mot de passe est obligatoire.';
    }

    if ($erreurs !== []) {
        afficherFormulaireConnexion($erreurs, $email);
        return;
    }

    $utilisateur = trouverUtilisateurParEmail($connexion, $email);

    // Même message d'erreur si compte inconnu ou mot de passe faux
    if ($utilisateur === null || !password_verify($motDePasse, $utilisateur['mot_de_passe'])) {
        $erreurs[] = 'Adresse électronique ou mot de passe incorrect.';
        afficherFormulaireConnexion($erreurs, $email);
        return;
    }

    // Authentification : démarrage et régénération de session
    if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
        session_start();
    }
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_regenerate_id(true);
    }

    $_SESSION['utilisateur'] = [
        'id' => (int) $utilisateur['id'],
        'nom' => $utilisateur['nom'],
        'prenom' => $utilisateur['prenom'],
        'email' => $utilisateur['email'],
        'telephone' => $utilisateur['telephone'],
    ];

    if (!headers_sent()) {
        header('Location: index.php?action=espace-connecte');
        exit;
    } else {
        afficherEspaceConnecte();
    }
}

// Affiche "Mon espace" (selon si l'utilisateur est connecté ou non)
function afficherEspaceConnecte(): void
{
    // Empêche la mise en cache de la page par le navigateur
    if (!headers_sent()) {
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Pragma: no-cache');
        header('Expires: 0');
    }

    $utilisateur = estConnecte() ? obtenirUtilisateurConnecte() : null;

    afficherVue('espace/index', [
        'titre' => $utilisateur !== null ? 'Espace enseignant — Covoiturage' : 'Mon espace — Covoiturage',
        'pageCourante' => 'espace-connecte',
        'utilisateur' => $utilisateur,
    ]);
}

// Déconnexion : vide la session et détruit le cookie
function traiterDeconnexion(): void
{
    if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
        session_start();
    }

    $_SESSION = [];

    if (ini_get('session.use_cookies') && !headers_sent()) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    if (session_status() === PHP_SESSION_ACTIVE) {
        session_destroy();
    }

    if (!headers_sent()) {
        header('Location: index.php?action=connexion');
        exit;
    } else {
        afficherFormulaireConnexion();
    }
}
