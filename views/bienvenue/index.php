<section aria-labelledby="titre-bienvenue" class="hero-card">
    <div class="hero-header">
        <h1 id="titre-bienvenue">Application de covoiturage</h1>
        <p class="hero-lead">Un espace pour organiser vos trajets entre collègues en toute simplicité.</p>
    </div>

    <div class="alert alert-success">
        <p>Bienvenue ! L’application a démarré avec succès.</p>
    </div>

    <div class="hero-actions">
        <?php if (function_exists('estConnecte') && estConnecte()): ?>
            <a href="index.php?action=espace-connecte" class="btn btn-primary">Accéder à mon espace</a>
            <a href="index.php?action=deconnexion" class="btn btn-secondary">Se déconnecter</a>
        <?php else: ?>
            <a href="index.php?action=connexion" class="btn btn-primary">Se connecter</a>
            <a href="index.php?action=creer-compte" class="btn btn-secondary">Créer un compte</a>
            <a href="index.php?action=espace-connecte" class="btn btn-outline">Mon espace</a>
        <?php endif; ?>
    </div>
</section>
