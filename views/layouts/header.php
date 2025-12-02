<?php
// views/layouts/header.php
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>CharityConnect</title>

    <!-- Bootstrap CSS (CDN) -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"
        crossorigin="anonymous"
    >

    <style>
        body {
            background-color: #f5f6fa;
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.03em;
        }
        .page-wrapper {
            background: #ffffff;
            border-radius: 10px;
            padding: 20px 24px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.06);
            margin-top: 24px;
            margin-bottom: 24px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-dark bg-dark shadow-sm">
    <div class="container">
        <span class="navbar-brand mb-0 h1">CharityConnect</span>
        <span class="text-light small">Back-office · Gestion des campagnes</span>
    </div>
</nav>

<div class="container">
    <div class="page-wrapper">
