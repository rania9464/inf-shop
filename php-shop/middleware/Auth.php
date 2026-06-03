<?php
class Auth {

    public static function check() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Vous devez vous connecter";
            header("Location: index.php?action=login");
            exit();
        }
    }

    public static function adminOnly() {
        self::check();
        if ($_SESSION['user_role'] !== 'admin') {
            $_SESSION['error'] = "Accès refusé — Admin seulement";
            header("Location: index.php?action=index");
            exit();
        }
    }

    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public static function isAdmin() {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }

    public static function userName() {
        return $_SESSION['user_name'] ?? 'Invité';
    }

    public static function userRole() {
        return $_SESSION['user_role'] ?? '';
    }
}
?>
