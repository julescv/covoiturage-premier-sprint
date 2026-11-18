<?php

// Recherche un compte par email
function trouverUtilisateurParEmail(PDO $connexion, string $email): ?array
{
    $requete = $connexion->prepare('SELECT * FROM utilisateurs WHERE LOWER(email) = LOWER(:email) LIMIT 1');
    $requete->execute([':email' => trim($email)]);
    $utilisateur = $requete->fetch();

    return $utilisateur !== false ? $utilisateur : null;
}

// Recherche un compte par son id
function trouverUtilisateurParId(PDO $connexion, int $id): ?array
{
    $requete = $connexion->prepare('SELECT * FROM utilisateurs WHERE id = :id LIMIT 1');
    $requete->execute([':id' => $id]);
    $utilisateur = $requete->fetch();

    return $utilisateur !== false ? $utilisateur : null;
}

// Enregistre un nouvel utilisateur avec mot de passe haché
function creerUtilisateur(PDO $connexion, array $utilisateur): int
{
    $nom = trim($utilisateur['nom'] ?? '');
    $prenom = trim($utilisateur['prenom'] ?? '');
    $email = strtolower(trim($utilisateur['email'] ?? ''));
    $telephone = trim($utilisateur['telephone'] ?? '');
    $motDePasseBrut = $utilisateur['mot_de_passe'] ?? '';

    $motDePasseHache = password_hash($motDePasseBrut, PASSWORD_DEFAULT);

    try {
        $connexion->beginTransaction();

        $requete = $connexion->prepare(
            'INSERT INTO utilisateurs (nom, prenom, email, telephone, mot_de_passe)
             VALUES (:nom, :prenom, :email, :telephone, :mot_de_passe)'
        );

        $requete->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':telephone' => $telephone,
            ':mot_de_passe' => $motDePasseHache,
        ]);

        $nouvelId = (int) $connexion->lastInsertId();

        $connexion->commit();

        return $nouvelId;
    } catch (PDOException $erreur) {
        if ($connexion->inTransaction()) {
            $connexion->rollBack();
        }

        // Email déjà existant
        if ($erreur->getCode() === '23000' || str_contains($erreur->getMessage(), 'UNIQUE')) {
            throw new RuntimeException('EMAIL_EXISTANT', 0, $erreur);
        }

        throw new RuntimeException('ERREUR_ENREGISTREMENT', 0, $erreur);
    }
}
