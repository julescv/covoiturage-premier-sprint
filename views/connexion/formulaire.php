<section aria-labelledby="titre-connexion">
    <div class="section-header">
        <h1 id="titre-connexion">Se connecter</h1>
        <p>Entrez votre adresse électronique et votre mot de passe pour accéder à votre espace.</p>
    </div>

    <?php if (!empty($erreurs)): ?>
        <div class="alert alert-danger" role="alert">
            <p><strong>Erreur de connexion :</strong></p>
            <ul>
                <?php foreach ($erreurs as $erreur): ?>
                    <li><?= htmlspecialchars($erreur, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="index.php?action=connexion" method="post" novalidate class="form-card">
        <div class="form-group">
            <label for="email">Adresse électronique <span class="required" aria-hidden="true">*</span> <span class="sr-only">(obligatoire)</span></label>
            <input type="email" id="email" name="email" required value="<?= htmlspecialchars($email ?? '', ENT_QUOTES, 'UTF-8') ?>" autocomplete="email">
        </div>

        <div class="form-group">
            <label for="mot_de_passe">Mot de passe <span class="required" aria-hidden="true">*</span> <span class="sr-only">(obligatoire)</span></label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required autocomplete="current-password">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
        </div>

        <p class="form-footer-link">
            Vous n’avez pas encore de compte ? <a href="index.php?action=creer-compte">Créer un compte</a>
        </p>
    </form>
</section>
