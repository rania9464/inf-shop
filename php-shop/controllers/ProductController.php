<?php
require_once __DIR__ . '/../models/ProductModel.php';

class ProductController {

    private $model;

    public function __construct($conn) {
        $this->model = new ProductModel($conn);
    }

    public function index() {
        $products = $this->model->getAllProducts();
        require_once __DIR__ . '/../views/products/index.php';
    }

    public function view($id) {
        $product = $this->model->getProductById($id);
        if ($product) {
            require_once __DIR__ . '/../views/products/view.php';
        } else {
            $_SESSION['error'] = "Produit introuvable";
            header("Location: index.php?action=index");
            exit();
        }
    }

    public function add() {
        $error = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom          = trim($_POST['nom']          ?? '');
            $prix         = trim($_POST['prix']         ?? '');
            $quantite     = trim($_POST['quantite']     ?? '');
            $categorie_id = trim($_POST['categorie_id'] ?? '');

            if (empty($nom) || empty($prix) || empty($quantite) || empty($categorie_id)) {
                $error = "Veuillez remplir tous les champs obligatoires";
            } elseif (!is_numeric($prix) || $prix < 0) {
                $error = "Le prix doit être un nombre positif";
            } elseif (!is_numeric($quantite) || $quantite < 0) {
                $error = "La quantité doit être un nombre positif";
            } else {
                $image  = $this->uploadImage($_FILES['image'] ?? null);
                $result = $this->model->addProduct($nom, $prix, $quantite, $image, $categorie_id);

                if ($result) {
                    $_SESSION['success'] = "Produit ajouté avec succès";
                    header("Location: index.php?action=index");
                    exit();
                } else {
                    $error = "Erreur lors de l'ajout";
                }
            }
        }

        $categories = $this->model->getAllCategories();
        require_once __DIR__ . '/../views/products/add.php';
    }

    public function edit($id) {
        $error   = "";
        $product = $this->model->getProductById($id);

        if (!$product) {
            $_SESSION['error'] = "Produit introuvable";
            header("Location: index.php?action=index");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom          = trim($_POST['nom']          ?? '');
            $prix         = trim($_POST['prix']         ?? '');
            $quantite     = trim($_POST['quantite']     ?? '');
            $categorie_id = trim($_POST['categorie_id'] ?? '');

            if (empty($nom) || empty($prix) || empty($quantite) || empty($categorie_id)) {
                $error = "Veuillez remplir tous les champs obligatoires";
            } else {
                $image = $product['image'];
                if (!empty($_FILES['image']['name'])) {
                    $image = $this->uploadImage($_FILES['image']);
                }

                $result = $this->model->updateProduct($id, $nom, $prix, $quantite, $image, $categorie_id);

                if ($result) {
                    $_SESSION['success'] = "Produit modifié avec succès";
                    header("Location: index.php?action=index");
                    exit();
                } else {
                    $error = "Erreur lors de la modification";
                }
            }
        }

        $categories = $this->model->getAllCategories();
        require_once __DIR__ . '/../views/products/edit.php';
    }

    public function delete($id) {
        if ($this->model->deleteProduct($id)) {
            $_SESSION['success'] = "Produit supprimé avec succès";
        } else {
            $_SESSION['error'] = "Erreur lors de la suppression";
        }
        header("Location: index.php?action=index");
        exit();
    }

    public function search() {
        $keyword  = trim($_POST['keyword'] ?? '');
        $products = $keyword
            ? $this->model->searchProduct($keyword)
            : $this->model->getAllProducts();
        require_once __DIR__ . '/../views/products/index.php';
    }

    private function uploadImage($file) {
        if (!$file || $file['error'] !== UPLOAD_ERR_OK || empty($file['name'])) {
            return 'default.png';
        }

        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext     = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            return 'default.png';
        }

        $newName = time() . '_' . rand(1000, 9999) . '.' . $ext;
        $dest    = __DIR__ . '/../uploads/' . $newName;

        if (move_uploaded_file($file['tmp_name'], $dest)) {
            return $newName;
        }

        return 'default.png';
    }
}
?>
