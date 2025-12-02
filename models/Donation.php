<?php
// models/Donation.php

require_once __DIR__ . "/../config/db.php";

class Donation {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // CREATE donation
    public function create($data) {
        $sql = "INSERT INTO donations (id_campaign, donor_name, amount)
                VALUES (:id_campaign, :donor_name, :amount)";
        
        $stmt = $this->conn->prepare($sql);

        $result = $stmt->execute([
            ':id_campaign' => $data['id_campaign'],
            ':donor_name'  => $data['donor_name'],
            ':amount'      => $data['amount']
        ]);

        if ($result) {
            $this->updateCollectedAmount($data['id_campaign'], $data['amount']);
        }

        return $result;
    }

    // mettre à jour le montant collecté dans la campagne
    private function updateCollectedAmount($id_campaign, $amount) {
        $sql = "UPDATE campaigns 
                SET amount_collected = amount_collected + :amount 
                WHERE id_campaign = :id_campaign";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':amount'      => $amount,
            ':id_campaign' => $id_campaign
        ]);
    }

    // récupérer tous les dons d'une campagne
    public function getByCampaign($id_campaign) {
        $sql = "SELECT donor_name, amount, created_at
                FROM donations
                WHERE id_campaign = :id_campaign
                ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id_campaign' => $id_campaign]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
