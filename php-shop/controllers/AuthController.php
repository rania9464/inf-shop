<?php
require_once __DIR__ . '/../models/UserModel.php';

class AuthController {

    private $model;

    public function __construct($conn) {
        $this->model = new UserModel($conn);
    }

    public function login() {
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php?action=index");
            exit();
        }

        $error = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email']    ?? '');
            $password = trim($_POST['password'] ?? '');

            if (empty($email) || empty($password)) {
                $error = "Veuillez remplir tous les champs";
            } else {
                $user = $this->model->authenticate($email, $password);
                if ($user) {
                    $_SESSION['user_id']   = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['user_role'] = $user['role'];
                    $_SESSION['success']   = "Bienvenue, " . htmlspecialchars($user['name']) . " !";
                    header("Location: index.php?action=index");
                    exit();
                } else {
                    $error = "Email ou mot de passe incorrect";
                }
            }
        }

        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function logout() {
        $name = $_SESSION['user_name'] ?? '';
        session_unset();
        session_destroy();
        session_start();
        $_SESSION['success'] = "Au revoir, " . htmlspecialchars($name) . " !";
        header("Location: index.php?action=login");
        exit();
    }

    public function register() {
        require_once __DIR__ . '/../middleware/Auth.php';
        Auth::adminOnly();

        $error = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name     = trim($_POST['name']     ?? '');
            $email    = trim($_POST['email']    ?? '');
            $password = trim($_POST['password'] ?? '');
            $role     = in_array($_POST['role'] ?? '', ['admin', 'user']) ? $_POST['role'] : 'user';

            if (empty($name) || empty($email) || empty($password)) {
                $error = "Veuillez remplir tous les champs";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Adresse email invalide";
            } elseif (strlen($password) < 6) {
                $error = "Mot de passe: minimum 6 caractères";
            } elseif ($this->model->emailExists($email)) {
                $error = "Cet email est déjà utilisé";
            } else {
                if ($this->model->create($name, $email, $password, $role)) {
                    $_SESSION['success'] = "Compte créé avec succès";
                    header("Location: index.php?action=users");
                    exit();
                } else {
                    $error = "Erreur lors de la création";
                }
            }
        }

        require_once __DIR__ . '/../views/auth/register.php';
    }

    public function users() {
        require_once __DIR__ . '/../middleware/Auth.php';
        Auth::adminOnly();
        $users = $this->model->getAll();
        require_once __DIR__ . '/../views/auth/users.php';
    }

    public function deleteUser($id) {
        require_once __DIR__ . '/../middleware/Auth.php';
        Auth::adminOnly();

        if ($id == $_SESSION['user_id']) {
            $_SESSION['error'] = "Impossible de supprimer votre propre compte";
            header("Location: index.php?action=users");
            exit();
        }

        if ($this->model->delete($id)) {
            $_SESSION['success'] = "Utilisateur supprimé";
        } else {
            $_SESSION['error'] = "Erreur lors de la suppression";
        }

        header("Location: index.php?action=users");
        exit();
    }
}
?>
