<?php
// index.php

require_once __DIR__ . "/controllers/CampaignController.php";

$controller = new CampaignController();

$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch ($action) {
    case 'create':
        $controller->create();
        break;
    case 'edit':
        $controller->edit();
        break;
    case 'delete':
        $controller->delete();
        break;
    case 'donate':
        $controller->donate();
        break;
    case 'donations':
        $controller->donations();
        break;
    default:
        $controller->index();
        break;
}
