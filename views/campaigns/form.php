<?php
// views/campaigns/form.php

$isEdit = ($action === 'edit');

$titleValue   = $isEdit && isset($campaign['title']) ? $campaign['title']         : ($_POST['title'] ?? '');
$descValue    = $isEdit && isset($campaign['description']) ? $campaign['description'] : ($_POST['description'] ?? '');
$catValue     = $isEdit && isset($campaign['category']) ? $campaign['category']   : ($_POST['category'] ?? '');
$targetValue  = $isEdit && isset($campaign['target_amount']) ? $campaign['target_amount'] : ($_POST['target_amount'] ?? '');
$statusValue  = $isEdit && isset($campaign['status']) ? $campaign['status']       : ($_POST['status'] ?? 'active');
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="h4 mb-0">
        <?= $isEdit ? "Modifier une campagne" : "Nouvelle campagne" ?>
    </h2>
    <a href="index.php" class="btn btn-outline-secondary btn-sm">← Retour</a>
</div>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger py-2">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<form method="post">
    <div class="mb-3">
        <label class="form-label">Titre</label>
        <input type="text"
               name="title"
               class="form-control"
               required
               value="<?= htmlspecialchars($titleValue) ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description"
                  rows="4"
                  class="form-control"
                  required><?= htmlspecialchars($descValue) ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Catégorie</label>
        <input type="text"
               name="category"
               class="form-control"
               required
               value="<?= htmlspecialchars($catValue) ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Objectif (montant en €)</label>
        <input type="number"
               step="0.01"
               name="target_amount"
               class="form-control"
               required
               value="<?= htmlspecialchars($targetValue) ?>">
    </div>

    <?php if ($isEdit): ?>
        <div class="mb-3">
            <label class="form-label">Statut</label>
            <select name="status" class="form-select">
                <option value="active"   <?= $statusValue === 'active' ? 'selected' : '' ?>>active</option>
                <option value="finished" <?= $statusValue === 'finished' ? 'selected' : '' ?>>terminée</option>
            </select>
        </div>
    <?php endif; ?>

    <button type="submit" class="btn btn-primary">
        <?= $isEdit ? "Enregistrer les modifications" : "Créer la campagne" ?>
    </button>
    <a href="index.php" class="btn btn-outline-secondary ms-2">Annuler</a>
</form>
