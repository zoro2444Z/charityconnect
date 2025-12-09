<?php
session_start();
require_once "db.php";

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullname = trim($_POST["fullname"]);
    $email    = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($fullname) || empty($email) || empty($password)) {
        $errors[] = "Tous les champs sont obligatoires.";
    }

    // Vérifier si l'email existe déjà
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $errors[] = "Cet email possède déjà un compte.";
        }
    }

    if (empty($errors)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("
            INSERT INTO users(fullname, email, password)
            VALUES (?, ?, ?)
        ");
        $stmt->execute([$fullname, $email, $hashed]);

        // connecter automatiquement l'utilisateur
        $_SESSION["user_id"]    = $pdo->lastInsertId();
        $_SESSION["user_name"]  = $fullname;
        $_SESSION["user_email"] = $email;

        header("Location: public.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un compte · CharityConnect</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container col-md-4 col-lg-3 mt-5">
    <div class="card shadow p-4">
        <h3 class="text-center mb-3">Créer un compte</h3>

        <?php foreach ($errors as $e): ?>
            <div class="alert alert-danger py-2"><?= htmlspecialchars($e) ?></div>
        <?php endforeach; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nom complet</label>
                <input class="form-control" type="text" name="fullname">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input class="form-control" type="email" name="email">
            </div>

            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <input class="form-control" type="password" name="password">
            </div>

            <button class="btn btn-primary w-100">Créer mon compte</button>
        </form>

        <p class="text-center mt-3 mb-0">
            Déjà un compte ? <a href="login.php">Se connecter</a>
        </p>
    </div>
</div>

</body>
</html>
