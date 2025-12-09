<?php
session_start();
require_once "db.php";

// Si l'utilisateur n'est pas connecté → retourner vers login
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Récupérer les dons de cet utilisateur
$sql = "
    SELECT d.donor_name, d.amount, d.created_at, c.title
    FROM donations d
    JOIN campaigns c ON c.id_campaign = d.id_campaign
    WHERE d.user_id = ?
    ORDER BY d.created_at DESC
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION["user_id"]]);
$donations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes dons · CharityConnect</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container col-md-7 mt-5">
    <div class="card shadow p-4">
        <h3 class="text-center mb-4">Historique de mes dons</h3>

        <?php if (empty($donations)): ?>
            <p class="text-center text-muted mb-0">
                Vous n'avez pas encore fait de don avec ce compte.
            </p>
        <?php else: ?>
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Campagne</th>
                        <th>Nom donné</th>
                        <th>Montant (€)</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($donations as $d): ?>
                    <tr>
                        <td><?= htmlspecialchars($d["title"]) ?></td>
                        <td><?= htmlspecialchars($d["donor_name"]) ?></td>
                        <td><?= htmlspecialchars($d["amount"]) ?></td>
                        <td><?= htmlspecialchars($d["created_at"]) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
