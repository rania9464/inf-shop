<?php
class OrderModel {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function placeOrder($user_id, $product_id, $quantite) {
        // Get product price and check stock
        $stmt = $this->conn->prepare("SELECT prix, quantite, nom FROM products WHERE id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) return ['ok' => false, 'msg' => "Produit introuvable"];

        $p = $result->fetch_assoc();
        if ($p['quantite'] < $quantite) return ['ok' => false, 'msg' => "Stock insuffisant (disponible: " . $p['quantite'] . ")"];

        $total = $p['prix'] * $quantite;

        // Insert order
        $stmt2 = $this->conn->prepare(
            "INSERT INTO commandes (user_id, product_id, quantite, prix_unitaire, total) VALUES (?,?,?,?,?)"
        );
        $stmt2->bind_param("iidd", $user_id, $product_id, $quantite, $p['prix'], $total);
        if (!$stmt2->execute()) return ['ok' => false, 'msg' => "Erreur lors de la commande"];

        $order_id = $this->conn->insert_id;

        // Reduce stock
        $stmt3 = $this->conn->prepare("UPDATE products SET quantite = quantite - ? WHERE id = ?");
        $stmt3->bind_param("ii", $quantite, $product_id);
        $stmt3->execute();

        return ['ok' => true, 'order_id' => $order_id, 'total' => $total, 'nom' => $p['nom']];
    }

    public function getOrderById($id) {
        $stmt = $this->conn->prepare(
            "SELECT c.*, p.nom AS produit_nom, p.image, u.name AS user_name, u.email AS user_email
             FROM commandes c
             JOIN products p ON c.product_id = p.id
             JOIN users u ON c.user_id = u.id
             WHERE c.id = ?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $r = $stmt->get_result();
        return $r->num_rows > 0 ? $r->fetch_assoc() : null;
    }

    public function getAllOrders() {
        return $this->conn->query(
            "SELECT c.*, p.nom AS produit_nom, u.name AS user_name, u.email AS user_email
             FROM commandes c
             JOIN products p ON c.product_id = p.id
             JOIN users u ON c.user_id = u.id
             ORDER BY c.created_at DESC"
        );
    }

    public function getMyOrders($user_id) {
        $stmt = $this->conn->prepare(
            "SELECT c.*, p.nom AS produit_nom, p.image
             FROM commandes c
             JOIN products p ON c.product_id = p.id
             WHERE c.user_id = ?
             ORDER BY c.created_at DESC"
        );
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function updateStatut($id, $statut) {
        $stmt = $this->conn->prepare("UPDATE commandes SET statut = ? WHERE id = ?");
        $stmt->bind_param("si", $statut, $id);
        return $stmt->execute();
    }

    public function deleteOrder($id) {
        $stmt = $this->conn->prepare("DELETE FROM commandes WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getTotalRevenue() {
        $r = $this->conn->query("SELECT SUM(total) AS revenue FROM commandes WHERE statut != 'annule'");
        return $r->fetch_assoc()['revenue'] ?? 0;
    }

    public function getTotalOrders() {
        $r = $this->conn->query("SELECT COUNT(*) AS cnt FROM commandes");
        return $r->fetch_assoc()['cnt'] ?? 0;
    }
}
?>
