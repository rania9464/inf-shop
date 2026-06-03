<?php
class ProductModel {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllProducts() {
        $sql = "SELECT p.*, c.nom AS categorie_nom
                FROM products p
                LEFT JOIN categories c ON p.categorie_id = c.id
                ORDER BY p.id DESC";
        return $this->conn->query($sql);
    }

    public function getProductById($id) {
        $sql = "SELECT p.*, c.nom AS categorie_nom
                FROM products p
                LEFT JOIN categories c ON p.categorie_id = c.id
                WHERE p.id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    public function getAllCategories() {
        return $this->conn->query("SELECT * FROM categories ORDER BY id ASC");
    }

    public function addProduct($nom, $prix, $quantite, $image, $categorie_id) {
        $stmt = $this->conn->prepare(
            "INSERT INTO products (nom, prix, quantite, image, categorie_id) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("sdisi", $nom, $prix, $quantite, $image, $categorie_id);
        return $stmt->execute();
    }

    public function updateProduct($id, $nom, $prix, $quantite, $image, $categorie_id) {
        $stmt = $this->conn->prepare(
            "UPDATE products SET nom=?, prix=?, quantite=?, image=?, categorie_id=? WHERE id=?"
        );
        $stmt->bind_param("sdisii", $nom, $prix, $quantite, $image, $categorie_id, $id);
        return $stmt->execute();
    }

    public function deleteProduct($id) {
        $product = $this->getProductById($id);
        if ($product && $product['image'] !== 'default.png') {
            $path = __DIR__ . '/../uploads/' . $product['image'];
            if (file_exists($path)) unlink($path);
        }
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function searchProduct($keyword) {
        $sql = "SELECT p.*, c.nom AS categorie_nom
                FROM products p
                LEFT JOIN categories c ON p.categorie_id = c.id
                WHERE p.nom LIKE ?
                ORDER BY p.id DESC";
        $stmt = $this->conn->prepare($sql);
        $term = "%" . $keyword . "%";
        $stmt->bind_param("s", $term);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>
