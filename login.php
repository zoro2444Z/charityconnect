<?php
session_start();
require_once "db.php";

$error = "";

// message spécial si on vient d'un bouton "Faire un don"
$mustLoginMsg = isset($_GET['must_login']) ? "Vous devez vous connecter pour faire un don." : "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email    = trim($_POST["email"]);
    $password = $_POST["password"];

    // Chercher l'utilisateur par email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password"])) {
        // Connexion OK
        $_SESSION["user_id"]    = $user["id_user"];
        $_SESSION["user_name"]  = $user["fullname"];
        $_SESSION["user_email"] = $user["email"];

        header("Location: public.php");
        exit();
    } else {
        $error = "Email ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion · CharityConnect</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container col-md-4 col-lg-3 mt-5">
    <div class="card shadow p-4">
        <h3 class="text-center mb-3">Connexion</h3>

        <?php if ($mustLoginMsg): ?>
            <div class="alert alert-warning py-2">
                <?= htmlspecialchars($mustLoginMsg) ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger py-2"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input class="form-control" type="email" name="email" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <input class="form-control" type="password" name="password" required>
            </div>

            <button class="btn btn-primary w-100">Se connecter</button>
        </form>

        <p class="text-center mt-3 mb-0">
            Pas encore de compte ? <a href="register.php">Créer un compte</a>
        </p>
    </div>
</div>

</body>
</html>
