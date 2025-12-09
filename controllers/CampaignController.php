<?php

require_once __DIR__ . "/../models/Campaign.php";
require_once __DIR__ . "/../models/Donation.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class CampaignController
{
    public function index()
    {
        $model = new Campaign();
        $campaigns = $model->getAll();

        include __DIR__ . "/../views/layouts/header.php";
        include __DIR__ . "/../views/campaigns/list.php";
        include __DIR__ . "/../views/layouts/footer.php";
    }

    public function create()
    {
        $error = "";
        $campaign = null;
        $action = "create";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (
                empty($_POST['title']) ||
                empty($_POST['description']) ||
                empty($_POST['category']) ||
                empty($_POST['target_amount'])
            ) {
                $error = "Tous les champs sont obligatoires.";
            } elseif (!is_numeric($_POST['target_amount']) || $_POST['target_amount'] <= 0) {
                $error = "L'objectif doit être un nombre positif.";
            } else {
                $model = new Campaign();
                $model->create($_POST);
                header("Location: index.php");
                exit();
            }
        }

        include __DIR__ . "/../views/layouts/header.php";
        include __DIR__ . "/../views/campaigns/form.php";
        include __DIR__ . "/../views/layouts/footer.php";
    }

    public function edit()
    {
        $model = new Campaign();
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $error = "";
        $campaign = $model->getById($id);
        $action = "edit";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (
                empty($_POST['title']) ||
                empty($_POST['description']) ||
                empty($_POST['category']) ||
                empty($_POST['target_amount']) ||
                empty($_POST['status'])
            ) {
                $error = "Tous les champs sont obligatoires.";
            } elseif (!is_numeric($_POST['target_amount']) || $_POST['target_amount'] <= 0) {
                $error = "L'objectif doit être un nombre positif.";
            } else {
                $model->update($id, $_POST);
                header("Location: index.php");
                exit();
            }

            $campaign['title']         = $_POST['title'];
            $campaign['description']   = $_POST['description'];
            $campaign['category']      = $_POST['category'];
            $campaign['target_amount'] = $_POST['target_amount'];
            $campaign['status']        = $_POST['status'];
        }

        include __DIR__ . "/../views/layouts/header.php";
        include __DIR__ . "/../views/campaigns/form.php";
        include __DIR__ . "/../views/layouts/footer.php";
    }

    public function delete()
    {
        $model = new Campaign();
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $model->delete($id);
        header("Location: index.php");
        exit();
    }

    /**
     * Faire un don
     * - on oblige l'utilisateur à être connecté
     * - on n'utilise plus de champ "Votre nom" : on prend le nom du compte
     */
    public function donate()
    {
        // 1) Vérifier la connexion
        if (!isset($_SESSION['user_id'])) {
            // on garde l'id de la campagne pour éventuellement s'en servir plus tard
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
            header("Location: login.php?must_login=1&campaign=" . $id);
            exit();
        }

        $campaignModel = new Campaign();
        $donationModel = new Donation();

        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $campaign = $campaignModel->getById($id);

        // savoir si on vient du site public pour la redirection
        $fromPublic = isset($_GET['from']) && $_GET['from'] === 'public';

        $error  = "";
        $amount = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $amount = trim($_POST['amount']);

            if ($amount === "") {
                $error = "Le montant est obligatoire.";
            } elseif (!is_numeric($amount) || $amount <= 0) {
                $error = "Le montant doit être un nombre positif.";
            } else {
                // enregistrement du don
                $donationModel->create([
                    'id_campaign' => $id,
                    'donor_name'  => $_SESSION['user_name'], // nom du compte
                    'amount'      => $amount,
                    'user_id'     => $_SESSION['user_id']    // même si create() ne l’utilise pas encore
                ]);

                if ($fromPublic) {
                    header("Location: public.php?success=1");
                } else {
                    header("Location: index.php");
                }
                exit();
            }
        }

        include __DIR__ . "/../views/layouts/header.php";
        include __DIR__ . "/../views/donations/form.php";
        include __DIR__ . "/../views/layouts/footer.php";
    }

    public function donations()
    {
        $campaignModel = new Campaign();
        $donationModel = new Donation();

        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        $campaign  = $campaignModel->getById($id);
        $donations = $donationModel->getByCampaign($id);

        include __DIR__ . "/../views/layouts/header.php";
        include __DIR__ . "/../views/donations/list.php";
        include __DIR__ . "/../views/layouts/footer.php";
    }
}
