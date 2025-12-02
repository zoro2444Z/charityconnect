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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = new Campaign();
            $model->create($_POST);
            header("Location: index.php");
            exit();
        }

        $campaign = null;
        $action = "create";
        include __DIR__ . "/../views/layouts/header.php";
        include __DIR__ . "/../views/campaigns/form.php";
        include __DIR__ . "/../views/layouts/footer.php";
    }

    public function edit() {
        $model = new Campaign();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model->update($id, $_POST);
            header("Location: index.php");
            exit();
        }

        $campaign = $model->getById($id);
        $action = "edit";
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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $donationModel->create([
                'id_campaign' => $id,
                'donor_name' => $_POST['donor_name'],
                'amount' => $_POST['amount']
            ]);
            header("Location: index.php");
            exit();
        }

        $campaign = $campaignModel->getById($id);

        include __DIR__ . "/../views/layouts/header.php";
        include __DIR__ . "/../views/donations/form.php";
        include __DIR__ . "/../views/layouts/footer.php";
    }
}
