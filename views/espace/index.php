<?php if (!empty($utilisateur)): ?>
<section aria-labelledby="titre-espace">
    <div class="alert alert-success">
        <p>Connexion réussie. Bienvenue dans votre espace covoiturage !</p>
    </div>

    <div class="section-header">
        <h1 id="titre-espace">Espace enseignant</h1>
        <p>Bonjour <strong><?= htmlspecialchars(($utilisateur['prenom'] ?? '') . ' ' . ($utilisateur['nom'] ?? ''), ENT_QUOTES, 'UTF-8') ?></strong>,</p>
    </div>

    <div class="profile-card">
        <h2 style="font-size: 1.25rem; margin-top: 0; color: #1e293b;">Vos informations de compte</h2>

        <div class="profile-details">
            <div class="detail-item">
                <span class="detail-label">Nom</span>
                <span class="detail-value"><?= htmlspecialchars($utilisateur['nom'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Prénom</span>
                <span class="detail-value"><?= htmlspecialchars($utilisateur['prenom'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Adresse électronique</span>
                <span class="detail-value"><?= htmlspecialchars($utilisateur['email'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Numéro de téléphone</span>
                <span class="detail-value"><?= htmlspecialchars($utilisateur['telephone'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
        </div>

        <p style="margin-bottom: 0; color: #64748b; font-size: 0.95rem;">
            En attendant la mise en ligne des offres de covoiturage, cet espace vous permet de vérifier vos informations personnelles.
        </p>
    </div>

    <div class="form-actions" style="margin-top: 1.75rem;">
        <a href="index.php?action=deconnexion" class="btn btn-secondary">Se déconnecter</a>
        <a href="index.php?action=bienvenue" class="btn btn-outline">Retour à l’accueil</a>
    </div>
</section>
<?php else: ?>
<section aria-labelledby="titre-espace">
    <div class="section-header">
        <h1 id="titre-espace">Mon espace</h1>
    </div>

    <div class="alert alert-warning" role="alert">
        <p>Veuillez vous connecter ou créer un compte pour voir votre espace.</p>
    </div>

    <div class="hero-card" style="margin-top: 1.5rem;">
        <p style="color: #64748b; margin-bottom: 1.25rem;">
            Cet espace vous permettra d’organiser vos trajets quotidiens, de proposer des trajets et de contacter vos collègues enseignants.
        </p>
        <div class="form-actions" style="justify-content: flex-start; gap: 0.85rem;">
            <a href="index.php?action=connexion" class="btn btn-primary">Se connecter</a>
            <a href="index.php?action=creer-compte" class="btn btn-secondary">Créer un compte</a>
        </div>
    </div>
</section>
<?php endif; ?>
