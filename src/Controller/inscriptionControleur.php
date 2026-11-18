<?php

require_once __DIR__ . '/../View/view.php';
require_once __DIR__ . '/../Model/Repository/parametreRepository.php';
require_once __DIR__ . '/../Model/Repository/utilisateurRepository.php';

// Affiche la vue du formulaire d'inscription
function afficherFormulaireInscription(PDO $connexion, array $erreurs = [], array $donnees = []): void
{
    afficherVue('inscription/formulaire', [
        'titre' => 'Créer un compte — Covoiturage',
        'pageCourante' => 'creer-compte',
        'erreurs' => $erreurs,
        'saisie' => $donnees,
    ]);
}

// Traitement du formulaire d'inscription
function traiterInscription(PDO $connexion): void
{
    $nom = trim((string) ($_POST['nom'] ?? ''));
    $prenom = trim((string) ($_POST['prenom'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $telephone = trim((string) ($_POST['telephone'] ?? ''));
    $motDePasse = (string) ($_POST['mot_de_passe'] ?? '');
    $codeInscription = trim((string) ($_POST['code_inscription'] ?? ''));

    // On préserve les champs pour réaffichage en cas d'erreur (hors mot de passe et code)
    $donnees = [
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'telephone' => $telephone,
    ];

    $erreurs = [];

    // Vérifie si le service est disponible (code renseigné en base)
    $codeAttendu = obtenirCodeInscription($connexion);
    if ($codeAttendu === null) {
        $erreurs[] = 'Le service d’inscription est indisponible. Réessayez plus tard.';
        afficherFormulaireInscription($connexion, $erreurs, $donnees);
        return;
    }

    // Champs obligatoires
    if ($nom === '') {
        $erreurs[] = 'Le nom est obligatoire.';
    }
    if ($prenom === '') {
        $erreurs[] = 'Le prénom est obligatoire.';
    }
    if ($email === '') {
        $erreurs[] = 'L’adresse électronique est obligatoire.';
    }
    if ($telephone === '') {
        $erreurs[] = 'Le numéro de téléphone est obligatoire.';
    }
    if (trim($motDePasse) === '') {
        $erreurs[] = 'Le mot de passe est obligatoire.';
    }

    // Contrôle du code d'inscription
    if ($codeInscription === '') {
        $erreurs[] = 'Code d’inscription obligatoire.';
    } elseif ($codeInscription !== $codeAttendu) {
        $erreurs[] = 'Code d’inscription incorrect.';
    }

    // Format et disponibilité de l'email
    if ($email !== '') {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erreurs[] = 'Veuillez saisir une adresse électronique valide.';
        } elseif (trouverUtilisateurParEmail($connexion, $email) !== null) {
            $erreurs[] = 'Cette adresse électronique est déjà utilisée par un autre compte.';
        }
    }

    // Format du téléphone attendu (10 chiffres)
    if ($telephone !== '') {
        if (!preg_match('/^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/', $telephone)) {
            $erreurs[] = 'Veuillez saisir un numéro de téléphone valide. Format attendu : 10 chiffres (ex. : 06 00 00 00 00).';
        }
    }

    if ($erreurs !== []) {
        afficherFormulaireInscription($connexion, $erreurs, $donnees);
        return;
    }

    // Enregistrement de l'utilisateur
    try {
        creerUtilisateur($connexion, [
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'telephone' => $telephone,
            'mot_de_passe' => $motDePasse,
        ]);

        afficherVue('inscription/succes', [
            'titre' => 'Compte créé avec succès — Covoiturage',
            'pageCourante' => 'creer-compte',
            'email' => $email,
        ]);
    } catch (RuntimeException $erreur) {
        if ($erreur->getMessage() === 'EMAIL_EXISTANT') {
            $erreurs[] = 'Cette adresse électronique est déjà utilisée par un autre compte.';
        } else {
            $erreurs[] = 'Une erreur est survenue lors de l’enregistrement de votre compte. Veuillez réessayer plus tard.';
        }

        afficherFormulaireInscription($connexion, $erreurs, $donnees);
    }
}
