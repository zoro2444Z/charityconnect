<?php
// views/campaigns/list.php
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="h4 mb-0">Campagnes de dons</h2>
    <a href="index.php?action=create" class="btn btn-primary">
        + Nouvelle campagne
    </a>
</div>

<table class="table table-striped table-hover table-bordered align-middle">
    <thead class="table-light">
        <tr>
            <th style="width: 60px;">ID</th>
            <th>Titre</th>
            <th>Catégorie</th>
            <th style="width: 130px;">Objectif</th>
            <th style="width: 130px;">Collecté</th>
            <th style="width: 110px;">Statut</th>
            <th style="width: 280px;">Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($campaigns)): ?>
        <?php foreach ($campaigns as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['id_campaign']) ?></td>
                <td><?= htmlspecialchars($c['title']) ?></td>
                <td><?= htmlspecialchars($c['category']) ?></td>
                <td><?= htmlspecialchars($c['target_amount']) ?> €</td>
                <td><?= htmlspecialchars($c['amount_collected']) ?> €</td>
                <td>
                    <?php if ($c['status'] === 'active'): ?>
                        <span class="badge bg-success">active</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">terminée</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a class="btn btn-sm btn-outline-primary me-1"
                       href="index.php?action=edit&id=<?= $c['id_campaign'] ?>">
                        Modifier
                    </a>

                    <a class="btn btn-sm btn-outline-danger me-1"
                       href="index.php?action=delete&id=<?= $c['id_campaign'] ?>"
                       onclick="return confirm('Supprimer cette campagne ?');">
                        Supprimer
                    </a>

                    <a class="btn btn-sm btn-primary me-1"
                       href="index.php?action=donate&id=<?= $c['id_campaign'] ?>">
                        Donner
                    </a>

                    <a class="btn btn-sm btn-outline-dark"
                       href="index.php?action=donations&id=<?= $c['id_campaign'] ?>">
                        Voir dons
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="7" class="text-center text-muted">
                Aucune campagne pour l’instant.
            </td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
