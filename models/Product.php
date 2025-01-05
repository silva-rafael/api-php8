<?php

// models/Product.php
class Product {
    private $conn;
    private $table = "products";

    public int $id;
    public string $name;
    public string $description;
    public float $price;
    public string $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create(): bool {
        $query = "INSERT INTO " . $this->table . " 
                 SET name = :name, 
                     description = :description, 
                     price = :price";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":price", $this->price);

        return $stmt->execute();
    }

    public function read(): array {
        $query = "SELECT id, name, description, price, created_at 
                 FROM " . $this->table . " 
                 ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readOne(): array {
        $query = "SELECT id, name, description, price, created_at 
                 FROM " . $this->table . " 
                 WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update(): bool {
        $query = "UPDATE " . $this->table . " 
                 SET name = :name, 
                     description = :description, 
                     price = :price 
                 WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    public function delete(): bool {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }
}