<section aria-labelledby="titre-formulaire">
    <div class="section-header">
        <h1 id="titre-formulaire">Créer un compte</h1>
        <p>Remplissez les informations ci-dessous pour créer votre compte enseignant. Tous les champs marqués d’un astérisque (<span class="required" aria-hidden="true">*</span>) sont obligatoires.</p>
    </div>

    <?php if (!empty($erreurs)): ?>
        <div class="alert alert-danger" role="alert">
            <p><strong>Veuillez corriger les erreurs suivantes :</strong></p>
            <ul>
                <?php foreach ($erreurs as $erreur): ?>
                    <li><?= htmlspecialchars($erreur, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php $valeurs = $saisie ?? $donnees['saisie'] ?? $donnees['donnees'] ?? []; ?>
    <form action="index.php?action=creer-compte" method="post" novalidate class="form-card">
        <div class="form-grid">
            <div class="form-group">
                <label for="nom">Nom <span class="required" aria-hidden="true">*</span> <span class="sr-only">(obligatoire)</span></label>
                <input type="text" id="nom" name="nom" required value="<?= htmlspecialchars($valeurs['nom'] ?? '', ENT_QUOTES, 'UTF-8') ?>" autocomplete="family-name">
            </div>

            <div class="form-group">
                <label for="prenom">Prénom <span class="required" aria-hidden="true">*</span> <span class="sr-only">(obligatoire)</span></label>
                <input type="text" id="prenom" name="prenom" required value="<?= htmlspecialchars($valeurs['prenom'] ?? '', ENT_QUOTES, 'UTF-8') ?>" autocomplete="given-name">
            </div>
        </div>

        <div class="form-group">
            <label for="email">Adresse électronique <span class="required" aria-hidden="true">*</span> <span class="sr-only">(obligatoire)</span></label>
            <input type="email" id="email" name="email" required value="<?= htmlspecialchars($valeurs['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" autocomplete="email">
            <small class="form-help">Sert d'identifiant de connexion.</small>
        </div>

        <div class="form-group">
            <label for="telephone">Numéro de téléphone <span class="required" aria-hidden="true">*</span> <span class="sr-only">(obligatoire)</span></label>
            <input type="tel" id="telephone" name="telephone" required value="<?= htmlspecialchars($valeurs['telephone'] ?? '', ENT_QUOTES, 'UTF-8') ?>" autocomplete="tel">
            <small class="form-help">Format attendu : 10 chiffres (ex. : 06 00 00 00 00 ou 0600000000).</small>
        </div>

        <div class="form-group">
            <label for="mot_de_passe">Mot de passe <span class="required" aria-hidden="true">*</span> <span class="sr-only">(obligatoire)</span></label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required autocomplete="new-password">
            <small class="form-help">Votre mot de passe personnel.</small>
        </div>

        <div class="form-group">
            <label for="code_inscription">Code d’inscription <span class="required" aria-hidden="true">*</span> <span class="sr-only">(obligatoire)</span></label>
            <input type="text" id="code_inscription" name="code_inscription" required autocomplete="off">
            <small class="form-help">Code d'accès transmis par l'établissement.</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-block">Créer mon compte</button>
        </div>

        <p class="form-footer-link">
            Vous avez déjà un compte ? <a href="index.php?action=connexion">Se connecter</a>
        </p>
    </form>
</section>
