<?php

session_start();
require_once __DIR__ . "/models/Campaign.php";

$model = new Campaign();
$campaigns = $model->getAll();
$totalCampaigns = count($campaigns);


$totalCollected = 0;
foreach ($campaigns as $c) {
    $totalCollected += $c['amount_collected'];
}


$success = isset($_GET['success']) && $_GET['success'] == 1;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>CharityConnect – Aidez une cause</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f5f6fa;
        }

        /* NAVBAR */
        .navbar-brand span {
            font-weight: 700;
            letter-spacing: 0.03em;
        }

        /* HERO */
        .hero-section {
            position: relative;
            background-image: url('https://picsum.photos/id/1012/1400/800');
            background-size: cover;
            background-position: center;
            min-height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }
        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(0,0,0,0.6), rgba(76,111,255,0.7));
        }
        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 720px;
            padding: 20px;
        }
        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            letter-spacing: 0.03em;
        }
        .hero-text {
            font-size: 1.1rem;
            opacity: 0.95;
        }

        /* SECTION TITLES */
        .section-title {
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        /* WHY BOXES */
        .why-box {
            text-align: center;
            padding: 24px 18px;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.06);
            height: 100%;
        }
        .why-icon {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        /* STATS / IMPACT */
        .stats-box {
            text-align: center;
            padding: 26px 18px;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.06);
            height: 100%;
        }
        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: #4c6fff;
        }
        .stats-label {
            font-size: 0.95rem;
            color: #555;
        }

        /* CAMPAIGN CARDS */
        .campaign-card {
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
            background: #fff;
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .campaign-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 26px rgba(0,0,0,0.18);
        }
        .campaign-img {
            height: 185px;
            object-fit: cover;
            width: 100%;
            background: #eaeaea;
        }

        /* COMMENT / QUOTES */
        .quote-box {
            background: #ffffff;
            border-radius: 16px;
            padding: 20px 22px;
            box-shadow: 0 6px 16px rgba(0,0,0,0.06);
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        /* CONTACT */
        .contact-box {
            background: #ffffff;
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 6px 16px rgba(0,0,0,0.06);
        }

        /* FOOTER */
        footer {
            background: #111;
            color: #ccc;
            padding: 22px 0;
            font-size: 0.9rem;
        }

        /* ANIMATIONS (scroll) */
        .fade-in-up {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .fade-in-up.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* GLOBE SECTION – proper top half */
        #globe-wrapper {
            background: #ffffff;
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 8px 22px rgba(0,0,0,0.08);
            height: 250px;
            overflow: hidden;
            display: flex;
            justify-content: center;
        }

        #poverty-globe {
            width: 100%;
            height: 500px;
            margin: 0 auto;
            margin-top: 0;
        }

        @media (max-width: 767px) {
            #globe-wrapper {
                height: 230px;
            }
            #poverty-globe {
                height: 460px;
                margin-top: 0;
            }
        }
    </style>
</head>

<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="public.php">
            <span>CharityConnect</span>
        </a>

        <div class="d-flex align-items-center gap-2">
            <a href="index.php" class="btn btn-outline-light btn-sm">Espace administrateur</a>

            <?php if (!isset($_SESSION["user_id"])): ?>
                <a href="login.php" class="btn btn-outline-light btn-sm">Connexion</a>
                <a href="register.php" class="btn btn-primary btn-sm">Créer un compte</a>
            <?php else: ?>
                <span class="text-white small">
                    Bonjour, <?= htmlspecialchars($_SESSION["user_name"]) ?>
                </span>
                <a href="history.php" class="btn btn-warning btn-sm">Mes dons</a>
                <a href="logout.php" class="btn btn-outline-light btn-sm">Déconnexion</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="hero-content fade-in-up">
        <h1 class="hero-title mb-3">Aidez une cause qui change des vies</h1>
        <p class="hero-text mb-3">
            Faites un geste solidaire et soutenez une campagne de dons en quelques secondes.
        </p>

        <?php if ($success): ?>
            <div class="alert alert-success mt-2">
                Merci pour votre don ❤️ Votre geste compte vraiment.
            </div>
        <?php endif; ?>

        <a href="#campaigns" class="btn btn-primary btn-lg mt-3 px-4">
            Voir les campagnes
        </a>
    </div>
</section>

<!-- WHY -->
<section class="py-5 bg-light">
    <div class="container fade-in-up">
        <h2 class="section-title text-center mb-4">Pourquoi CharityConnect ?</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="why-box">
                    <div class="why-icon">✨</div>
                    <h5>Simple & rapide</h5>
                    <p class="text-muted mb-0">Une interface fluide pour faire un don facilement.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="why-box">
                    <div class="why-icon">🔒</div>
                    <h5>Pédagogique</h5>
                    <p class="text-muted mb-0">Un projet MVC idéal pour apprendre PHP/MySQL.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="why-box">
                    <div class="why-icon">📊</div>
                    <h5>Suivi clair</h5>
                    <p class="text-muted mb-0">Montants mis à jour automatiquement.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- HOW -->
<section class="py-5">
    <div class="container fade-in-up">
        <h2 class="section-title text-center mb-4">Comment ça marche ?</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="why-box">
                    <h5>1. Création de la campagne</h5>
                    <p class="text-muted mb-0">
                        L’administrateur ajoute une campagne avec un titre, une catégorie et un objectif.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="why-box">
                    <h5>2. Don côté utilisateur</h5>
                    <p class="text-muted mb-0">
                        Sur la page publique, un utilisateur choisit une campagne et renseigne son don.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="why-box">
                    <h5>3. Mise à jour automatique</h5>
                    <p class="text-muted mb-0">
                        Le don est enregistré et le total collecté est calculé automatiquement.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- STATS -->
<section class="py-5 bg-light">
    <div class="container fade-in-up">
        <h2 class="section-title text-center mb-4">Notre impact </h2>
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="stats-box">
                    <div class="stats-number">2024</div>
                    <div class="stats-label">Année de lancement</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-box">
                    <div class="stats-number"><?= $totalCampaigns ?></div>
                    <div class="stats-label">Campagnes créées</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-box">
                    <div class="stats-number"><?= number_format($totalCollected, 2) ?> €</div>
                    <div class="stats-label">Total collecté</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CAMPAIGNS -->
<section id="campaigns" class="py-5">
    <div class="container fade-in-up">
        <h2 class="section-title text-center mb-4">Campagnes disponibles</h2>

        <div class="row g-4">
            <?php
            $images = [
                "https://picsum.photos/id/1011/800/500",
                "https://picsum.photos/id/1015/800/500",
                "https://picsum.photos/id/1025/800/500",
                "https://picsum.photos/id/1035/800/500",
                "https://picsum.photos/id/1069/800/500",
                "https://picsum.photos/id/1074/800/500"
            ];
            ?>

            <?php if (!empty($campaigns)): ?>
                <?php foreach ($campaigns as $index => $c): ?>
                    <?php
                    $target = max(1, $c['target_amount']);
                    $pct = min(100, ($c['amount_collected'] / $target) * 100);
                    ?>
                    <div class="col-md-4">
                        <div class="campaign-card fade-in-up">
                            <img src="<?= $images[$index % count($images)] ?>" class="campaign-img" alt="Illustration campagne">
                            <div class="p-3 d-flex flex-column flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-primary">
                                        <?= htmlspecialchars($c['category']) ?>
                                    </span>
                                    <span class="badge <?= $c['status'] === 'active' ? 'bg-success' : 'bg-secondary' ?>">
                                        <?= htmlspecialchars($c['status']) ?>
                                    </span>
                                </div>

                                <h5><?= htmlspecialchars($c['title']) ?></h5>
                                <p class="text-muted small">
                                    <?= htmlspecialchars(substr($c['description'], 0, 90)) ?><?= strlen($c['description']) > 90 ? '…' : '' ?>
                                </p>

                                <p class="mb-1"><strong>Objectif :</strong> <?= $c['target_amount'] ?> €</p>
                                <p class="mb-1"><strong>Collecté :</strong> <?= $c['amount_collected'] ?> €</p>

                                <div class="progress mb-2" style="height:6px;">
                                    <div class="progress-bar" style="width:<?= $pct ?>%;"></div>
                                </div>

                                <?php if (!isset($_SESSION['user_id'])): ?>
                                    <!-- Pas connecté : rediriger vers la page de connexion -->
                                    <a href="login.php?must_login=1"
                                       class="btn btn-primary mt-auto">
                                        Faire un don
                                    </a>
                                <?php else: ?>
                                    <!-- Connecté : aller au formulaire de don -->
                                    <a href="index.php?action=donate&id=<?= $c['id_campaign'] ?>&from=public"
                                       class="btn btn-primary mt-auto">
                                        Faire un don
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">Aucune campagne disponible pour l’instant.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- COMMENTS -->
<section class="py-5 bg-light">
    <div class="container fade-in-up">
        <h2 class="section-title text-center mb-4">Commentaires </h2>
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="quote-box">
                    “L’interface est claire et facile à comprendre.”
                </div>
            </div>
            <div class="col-md-4">
                <div class="quote-box">
                    “On voit directement l’impact des dons sur chaque campagne.”
                </div>
            </div>
            <div class="col-md-4">
                <div class="quote-box">
                    “Parfait comme exemple pour apprendre le développement web.”
                </div>
            </div>
        </div>
    </div>
</section>

<!-- GLOBE SECTION -->
<section class="py-5">
    <div class="container fade-in-up">
        <h2 class="section-title text-center mb-3">Un regard sur les régions les plus fragiles</h2>
        <p class="text-center text-muted mb-4">
            Sphère pédagogique montrant quelques zones fortement touchées par la pauvreté.
        </p>
        <div id="globe-wrapper">
            <div id="poverty-globe"></div>
        </div>
    </div>
</section>

<!-- CONTACT -->
<section class="py-5">
    <div class="container fade-in-up">
        <h2 class="section-title mb-4">Contact & informations</h2>
        <div class="row g-4 align-items-center">
            <div class="col-md-6">
                <p class="text-muted">
                    Ce projet est une maquette pédagogique réalisée en PHP / MySQL avec MVC.
                    Il sert à comprendre la structure d’un site (back-office + front-office, base de données, formulaires, etc.).
                </p>
                <p class="text-muted mb-0">
                    Pour toute question, merci de contacter l’enseignant ou l’équipe projet.
                </p>
            </div>
            <div class="col-md-6">
                <div class="contact-box">
                    <h5 class="mb-3">Formulaire de contact (simulation)</h5>
                    <input type="text" class="form-control mb-2" placeholder="Votre nom">
                    <input type="email" class="form-control mb-2" placeholder="Votre e-mail">
                    <textarea class="form-control mb-2" rows="3" placeholder="Votre message "></textarea>
                    <button class="btn btn-secondary w-100" disabled>Envoyer</button>
                </div>
            </div>
        </div>
    </div>
</section>

<footer>
    <div class="container text-center">
        CharityConnect · Plateforme de dons · 2025
    </div>
</footer>

<!-- JS LIBRARIES -->
<script src="https://unpkg.com/three@0.150.1/build/three.min.js"></script>
<script src="https://unpkg.com/globe.gl@2.30.0/dist/globe.gl.min.js"></script>

<!-- SCROLL ANIMATIONS -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.fade-in-up').forEach(el => {
        const obs = new IntersectionObserver((entries, o) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.classList.add('show');
                    o.unobserve(e.target);
                }
            });
        }, { threshold: 0.2 });
        obs.observe(el);
    });
});
</script>

<!-- GLOBE: metallic, top half, glowing dots -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const el = document.getElementById('poverty-globe');
    if (!el || typeof Globe === 'undefined') return;

    const points = [
        {lat: 13.5, lng: 2.1},
        {lat: 7.5,  lng: 20.7},
        {lat: -3.4, lng: 29.9},
        {lat: 27.7, lng: 85.3},
        {lat: 18.0, lng: 102.6},
        {lat: -17.8,lng: 31.0}
    ];

    const world = Globe()
        .globeImageUrl('https://unpkg.com/three-globe/example/img/earth-dark.jpg')
        .bumpImageUrl('https://unpkg.com/three-globe/example/img/earth-topology.png')
        .backgroundColor('rgba(0,0,0,0)')
        .showAtmosphere(false)
        .labelsData(points)
        .labelLat('lat')
        .labelLng('lng')
        .labelText(() => '')
        .labelSize(0)
        .labelDotRadius(0.55)
        .labelColor(() => 'rgba(0, 220, 255, 0.95)')
        .labelAltitude(0.01)
        (el);

    function resize() {
        world.width(el.clientWidth);
        world.height(el.clientHeight);
    }
    resize();
    window.addEventListener('resize', resize);

    world.pointOfView({ lat: 35, lng: -20, altitude: 1.9 }, 0);
    world.controls().autoRotate = true;
    world.controls().autoRotateSpeed = 0.7;
});
</script>

</body>
</html>
