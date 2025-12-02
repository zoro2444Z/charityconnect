<?php
// views/donations/form.php

// si la variable vient du controller, on l’utilise pour savoir où revenir
$backUrl = (!empty($fromPublic) && $fromPublic === true) ? 'public.php' : 'index.php';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="h4 mb-0">
        Faire un don pour : <?= htmlspecialchars($campaign['title']) ?>
    </h2>
    <a href="<?= $backUrl ?>" class="btn btn-outline-secondary btn-sm">← Retour</a>
</div>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger py-2">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<form method="post">
    <div class="mb-3">
        <label class="form-label">Votre nom</label>
        <input type="text"
               name="donor_name"
               class="form-control"
               required
               value="<?= htmlspecialchars($donor_name ?? ($_POST['donor_name'] ?? '')) ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Montant du don (€)</label>
        <input type="number"
               step="0.01"
               name="amount"
               class="form-control"
               required
               value="<?= htmlspecialchars($amount ?? ($_POST['amount'] ?? '')) ?>">
    </div>

    <button class="btn btn-primary" type="submit">Faire le don</button>
    <a href="<?= $backUrl ?>" class="btn btn-outline-secondary ms-2">Annuler</a>
</form>
