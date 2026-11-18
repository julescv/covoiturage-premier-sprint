<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titre, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <div class="brand">
            <div class="brand-badge" aria-hidden="true">🚗</div>
            <div>
                <p class="brand-title">Covoiturage entre enseignants</p>
                <p class="subtitle">Partageons nos trajets entre collègues.</p>
            </div>
        </div>

        <nav class="nav-bar" aria-label="Navigation principale">
            <a href="index.php?action=bienvenue"<?= $pageCourante === 'bienvenue' ? ' class="active" aria-current="page"' : '' ?>>Bienvenue</a>
            <a href="index.php?action=espace-connecte"<?= in_array($pageCourante, ['espace-connecte', 'espace-enseignant'], true) ? ' class="active" aria-current="page"' : '' ?>>Mon espace</a>
            <?php if (function_exists('estConnecte') && estConnecte()): ?>
                <?php $utilisateurConnecte = obtenirUtilisateurConnecte(); ?>
                <a href="index.php?action=deconnexion" class="btn-deconnexion">Se déconnecter</a>
                <span class="user-badge" aria-label="Utilisateur connecté">
                    Connecté : <?= htmlspecialchars(($utilisateurConnecte['prenom'] ?? '') . ' ' . ($utilisateurConnecte['nom'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                </span>
            <?php else: ?>
                <a href="index.php?action=creer-compte"<?= in_array($pageCourante, ['creer-compte', 'creer-mon-compte', 'inscription'], true) ? ' class="active" aria-current="page"' : '' ?>>Créer un compte</a>
                <a href="index.php?action=connexion"<?= in_array($pageCourante, ['connexion', 'se-connecter'], true) ? ' class="active" aria-current="page"' : '' ?>>Se connecter</a>
            <?php endif; ?>
        </nav>
    </header>

    <main>
        <?= $contenu ?>
    </main>
</body>

</html>
