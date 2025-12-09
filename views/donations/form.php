<?php
// vue du formulaire de don : views/donations/form.php

// On suppose que la session est déjà démarrée dans le contrôleur
$isLogged = isset($_SESSION['user_id']);
?>
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="mb-4">
                Faire un don pour :
                <?= htmlspecialchars($campaign['title'] ?? '') ?>
            </h3>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger py-2 mb-3">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="post">

                <?php if (!$isLogged): ?>
                    <!-- Pas connecté (back-office) : on demande le nom -->
                    <div class="mb-3">
                        <label class="form-label">Votre nom</label>
                        <input
                            type="text"
                            name="donor_name"
                            class="form-control"
                            value="<?= htmlspecialchars($donor_name ?? '') ?>">
                    </div>
                <?php else: ?>
                    <!-- Connecté : on affiche le nom du compte, non modifiable -->
                    <div class="mb-3">
                        <label class="form-label">Votre nom</label>
                        <input
                            type="text"
                            class="form-control"
                            value="<?= htmlspecialchars($_SESSION['user_name']) ?>"
                            disabled>
                        <div class="form-text">
                            Ce nom provient de votre compte utilisateur.
                        </div>
                    </div>
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label">Montant du don (€)</label>
                    <input
                        type="number"
                        name="amount"
                        class="form-control"
                        step="0.01"
                        min="0"
                        value="<?= htmlspecialchars($amount ?? '') ?>">
                </div>

                <button type="submit" class="btn btn-primary">
                    Faire le don
                </button>
                <a href="index.php" class="btn btn-outline-secondary">Annuler</a>
            </form>
        </div>
    </div>
</div>
