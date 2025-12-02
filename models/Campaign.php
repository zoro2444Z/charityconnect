<?php
// models/Campaign.php

require_once __DIR__ . "/../config/db.php";

class Campaign {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // READ : toutes les campagnes
    public function getAll() {
        $sql = "SELECT * FROM campaigns ORDER BY id_campaign DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ : une campagne
    public function getById($id) {
        $sql = "SELECT * FROM campaigns WHERE id_campaign = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // CREATE
    public function create($data) {
        $sql = "INSERT INTO campaigns (title, description, category, target_amount, amount_collected, status)
                VALUES (:title, :description, :category, :target_amount, 0, 'active')";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':category' => $data['category'],
            ':target_amount' => $data['target_amount']
        ]);
    }

    // UPDATE
    public function update($id, $data) {
        $sql = "UPDATE campaigns
                SET title = :title,
                    description = :description,
                    category = :category,
                    target_amount = :target_amount,
                    status = :status
                WHERE id_campaign = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':category' => $data['category'],
            ':target_amount' => $data['target_amount'],
            ':status' => $data['status'],
            ':id' => $id
        ]);
    }

    // DELETE
    public function delete($id) {
        $sql = "DELETE FROM campaigns WHERE id_campaign = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
