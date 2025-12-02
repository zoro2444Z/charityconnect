<?php
// controllers/CampaignController.php

require_once __DIR__ . "/../models/Campaign.php";
require_once __DIR__ . "/../models/Donation.php";

class CampaignController {

    public function index() {
        $model = new Campaign();
        $campaigns = $model->getAll();
        include __DIR__ . "/../views/layouts/header.php";
        include __DIR__ . "/../views/campaigns/list.php";
        include __DIR__ . "/../views/layouts/footer.php";
    }

    public function create() {
        $error = "";
        $campaign = null;
        $action = "create";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['title']) || empty($_POST['description']) || empty($_POST['category']) || empty($_POST['target_amount'])) {
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

    public function edit() {
        $model = new Campaign();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $error = "";
        $campaign = $model->getById($id);
        $action = "edit";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['title']) || empty($_POST['description']) || empty($_POST['category']) || empty($_POST['target_amount']) || empty($_POST['status'])) {
                $error = "Tous les champs sont obligatoires.";
            } elseif (!is_numeric($_POST['target_amount']) || $_POST['target_amount'] <= 0) {
                $error = "L'objectif doit être un nombre positif.";
            } else {
                $model->update($id, $_POST);
                header("Location: index.php");
                exit();
            }

            $campaign['title']          = $_POST['title'];
            $campaign['description']    = $_POST['description'];
            $campaign['category']       = $_POST['category'];
            $campaign['target_amount']  = $_POST['target_amount'];
            $campaign['status']         = $_POST['status'];
        }

        include __DIR__ . "/../views/layouts/header.php";
        include __DIR__ . "/../views/campaigns/form.php";
        include __DIR__ . "/../views/layouts/footer.php";
    }

    public function delete() {
        $model = new Campaign();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $model->delete($id);
        header("Location: index.php");
        exit();
    }

    public function donate() {
        $campaignModel = new Campaign();
        $donationModel = new Donation();

        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $campaign = $campaignModel->getById($id);

        $fromPublic = isset($_GET['from']) && $_GET['from'] === 'public';

        $error = "";
        $donor_name = "";
        $amount = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $donor_name = trim($_POST['donor_name']);
            $amount = trim($_POST['amount']);

            if ($donor_name === "" || $amount === "") {
                $error = "Tous les champs sont obligatoires.";
            } elseif (!is_numeric($amount) || $amount <= 0) {
                $error = "Le montant doit être un nombre positif.";
            } else {
                $donationModel->create([
                    'id_campaign' => $id,
                    'donor_name'  => $donor_name,
                    'amount'      => $amount
                ]);

                // REDIRECTION : si on vient du site public, on y retourne
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

    public function donations() {
        $campaignModel  = new Campaign();
        $donationModel  = new Donation();

        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        $campaign  = $campaignModel->getById($id);
        $donations = $donationModel->getByCampaign($id);

        include __DIR__ . "/../views/layouts/header.php";
        include __DIR__ . "/../views/donations/list.php";
        include __DIR__ . "/../views/layouts/footer.php";
    }
}
