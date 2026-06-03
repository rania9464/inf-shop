<?php
require_once __DIR__ . '/../models/OrderModel.php';
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../middleware/Auth.php';

class OrderController {

    private $model;
    private $productModel;

    public function __construct($conn) {
        $this->model        = new OrderModel($conn);
        $this->productModel = new ProductModel($conn);
    }

    public function buy($product_id) {
        Auth::check();
        $product = $this->productModel->getProductById($product_id);
        if (!$product) {
            $_SESSION['error'] = "Produit introuvable";
            header("Location: index.php?action=index");
            exit();
        }

        $error = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $quantite = (int)($_POST['quantite'] ?? 1);
            if ($quantite < 1) {
                $error = "La quantité doit être au moins 1";
            } else {
                $result = $this->model->placeOrder(
                    $_SESSION['user_id'],
                    $product_id,
                    $quantite
                );
                if ($result['ok']) {
                    $_SESSION['success'] = "Commande #{$result['order_id']} passée avec succès !";
                    header("Location: index.php?action=order_success&id=" . $result['order_id']);
                    exit();
                } else {
                    $error = $result['msg'];
                }
            }
        }

        require_once __DIR__ . '/../views/orders/buy.php';
    }

    public function success($order_id) {
        Auth::check();
        $order = $this->model->getOrderById($order_id);
        if (!$order || $order['user_id'] != $_SESSION['user_id']) {
            header("Location: index.php?action=index");
            exit();
        }
        require_once __DIR__ . '/../views/orders/success.php';
    }

    public function allOrders() {
        Auth::adminOnly();
        $orders = $this->model->getAllOrders();
        $revenue = $this->model->getTotalRevenue();
        $total   = $this->model->getTotalOrders();
        require_once __DIR__ . '/../views/orders/index.php';
    }

    public function myOrders() {
        Auth::check();
        $orders = $this->model->getMyOrders($_SESSION['user_id']);
        require_once __DIR__ . '/../views/orders/my_orders.php';
    }

    public function updateStatut($id) {
        Auth::adminOnly();
        $statut = $_POST['statut'] ?? '';
        if (in_array($statut, ['en_attente', 'confirme', 'annule'])) {
            $this->model->updateStatut($id, $statut);
            $_SESSION['success'] = "Statut mis à jour";
        }
        header("Location: index.php?action=orders");
        exit();
    }

    public function deleteOrder($id) {
        Auth::adminOnly();
        $this->model->deleteOrder($id);
        $_SESSION['success'] = "Commande supprimée";
        header("Location: index.php?action=orders");
        exit();
    }
}
?>
