<?php
// views/donations/list.php
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="h4 mb-0">
        Dons pour la campagne : <?= htmlspecialchars($campaign['title']) ?>
    </h2>
    <a href="index.php" class="btn btn-outline-secondary btn-sm">← Retour aux campagnes</a>
</div>

<p>
    <strong>Objectif :</strong> <?= htmlspecialchars($campaign['target_amount']) ?> €<br>
    <strong>Total collecté :</strong> <?= htmlspecialchars($campaign['amount_collected']) ?> €
</p>

<?php if (!empty($donations)): ?>
    <table class="table table-striped table-hover table-bordered align-middle mt-3">
        <thead class="table-light">
            <tr>
                <th>Donateur</th>
                <th style="width: 150px;">Montant (€)</th>
                <th style="width: 200px;">Date</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($donations as $d): ?>
            <tr>
                <td><?= htmlspecialchars($d['donor_name']) ?></td>
                <td><?= htmlspecialchars($d['amount']) ?></td>
                <td><?= htmlspecialchars($d['created_at']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="alert alert-info mt-3">
        Aucun don pour cette campagne pour l’instant.
    </div>
<?php endif; ?>
