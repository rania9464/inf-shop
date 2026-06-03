<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Setup — Shop Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body{font-family:'Inter',sans-serif;background:#f1f5f9;display:flex;align-items:center;justify-content:center;min-height:100vh;}
        .box{background:white;border-radius:16px;padding:40px;max-width:560px;width:100%;box-shadow:0 4px 20px rgba(0,0,0,.08);}
        .step{display:flex;align-items:flex-start;gap:14px;padding:12px 0;border-bottom:1px solid #f1f5f9;}
        .step:last-child{border-bottom:none;}
        .icon{width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;}
        .ok {background:#dcfce7;color:#15803d;}
        .err{background:#fee2e2;color:#dc2626;}
        pre{background:#f8fafc;padding:12px;border-radius:8px;font-size:12px;margin-top:8px;border:1px solid #e2e8f0;}
    </style>
</head>
<body>
<div class="box">
    <div style="text-align:center;margin-bottom:28px;">
        <div style="font-size:48px;">🏪</div>
        <h4 style="font-weight:700;color:#1e293b;margin-top:8px;">Setup — Shop Manager</h4>
        <p style="color:#94a3b8;font-size:14px;">Configuration automatique de la base de données</p>
    </div>

<?php
$host   = "localhost";
$user   = "root";
$pass   = "";
$dbname = "shop";
$steps  = [];

$conn = @new mysqli($host, $user, $pass);
if ($conn->connect_error) {
    $steps[] = ['err', 'Connexion MySQL échouée', $conn->connect_error];
    showSteps($steps); exit();
}
$steps[] = ['ok', 'Connexion MySQL réussie', ''];

$conn->query("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8 COLLATE utf8_unicode_ci");
$conn->select_db($dbname);
$steps[] = ['ok', "Base de données '$dbname' prête", ''];

$tables = [
    "categories" => "CREATE TABLE IF NOT EXISTS categories (
        id  INT AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(100) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8",

    "products" => "CREATE TABLE IF NOT EXISTS products (
        id           INT AUTO_INCREMENT PRIMARY KEY,
        nom          VARCHAR(100)   NOT NULL,
        prix         DECIMAL(10,2)  NOT NULL DEFAULT 0,
        quantite     INT            NOT NULL DEFAULT 0,
        image        VARCHAR(255)   DEFAULT 'default.png',
        categorie_id INT,
        FOREIGN KEY (categorie_id) REFERENCES categories(id) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8",

    "users" => "CREATE TABLE IF NOT EXISTS users (
        id         INT AUTO_INCREMENT PRIMARY KEY,
        name       VARCHAR(100)  NOT NULL,
        email      VARCHAR(150)  NOT NULL UNIQUE,
        password   VARCHAR(255)  NOT NULL,
        role       ENUM('admin','user') NOT NULL DEFAULT 'user',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8",

    "commandes" => "CREATE TABLE IF NOT EXISTS commandes (
        id            INT AUTO_INCREMENT PRIMARY KEY,
        user_id       INT NOT NULL,
        product_id    INT NOT NULL,
        quantite      INT NOT NULL DEFAULT 1,
        prix_unitaire DECIMAL(10,2) NOT NULL,
        total         DECIMAL(10,2) NOT NULL,
        statut        ENUM('en_attente','confirme','annule') DEFAULT 'confirme',
        created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id)    REFERENCES users(id)    ON DELETE CASCADE,
        FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8",
];

foreach ($tables as $name => $sql) {
    if ($conn->query($sql)) {
        $steps[] = ['ok', "Table '$name' créée / vérifiée", ''];
    } else {
        $steps[] = ['err', "Erreur table '$name'", $conn->error];
    }
}

$r = $conn->query("SELECT COUNT(*) AS c FROM categories"); $row = $r->fetch_assoc();
if ($row['c'] == 0) {
    $conn->query("INSERT INTO categories (nom) VALUES ('Laptop'),('Phone'),('Accessoires')");
    $steps[] = ['ok', '3 catégories insérées', ''];
} else {
    $steps[] = ['ok', 'Catégories déjà présentes ('.$row['c'].')', ''];
}

$r = $conn->query("SELECT COUNT(*) AS c FROM products"); $row = $r->fetch_assoc();
if ($row['c'] == 0) {
    $conn->query("INSERT INTO products (nom,prix,quantite,image,categorie_id) VALUES
        ('Dell XPS 15',1500.00,10,'default.png',1),
        ('MacBook Pro 14',2500.00,5,'default.png',1),
        ('iPhone 15 Pro',1200.00,20,'default.png',2),
        ('Samsung S24',950.00,15,'default.png',2),
        ('AirPods Pro',350.00,30,'default.png',3)");
    $steps[] = ['ok', '5 produits insérés', ''];
} else {
    $steps[] = ['ok', 'Produits déjà présents ('.$row['c'].')', ''];
}

$r = $conn->query("SELECT COUNT(*) AS c FROM users"); $row = $r->fetch_assoc();
if ($row['c'] == 0) {
    $adminHash = password_hash('admin123', PASSWORD_DEFAULT);
    $userHash  = password_hash('user123',  PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (name,email,password,role) VALUES (?,?,?,?)");
    $n1='Administrateur'; $e1='admin@shop.com'; $r1='admin';
    $stmt->bind_param("ssss",$n1,$e1,$adminHash,$r1); $stmt->execute();
    $n2='Utilisateur'; $e2='user@shop.com'; $r2='user';
    $stmt->bind_param("ssss",$n2,$e2,$userHash,$r2);  $stmt->execute();
    $steps[] = ['ok', '2 comptes créés (admin + user)', ''];
} else {
    $steps[] = ['ok', 'Comptes déjà présents ('.$row['c'].')', ''];
}

$conn->close();
showSteps($steps);

function showSteps($steps) {
    foreach ($steps as $s) {
        $icon = $s[0]==='ok' ? '✓' : '✗';
        echo "<div class='step'>";
        echo "<div class='icon {$s[0]}'>$icon</div>";
        echo "<div><strong style='font-size:14px;'>{$s[1]}</strong>";
        if (!empty($s[2])) echo "<pre>{$s[2]}</pre>";
        echo "</div></div>";
    }
}
?>

    <div style="margin-top:28px;text-align:center;">
        <a href="index.php" style="background:#6366f1;color:white;padding:12px 32px;border-radius:10px;text-decoration:none;font-weight:600;font-size:15px;display:inline-block;">
            🚀 Accéder au site
        </a>
    </div>

    <div style="margin-top:20px;background:#f8fafc;border-radius:10px;padding:16px;font-size:13px;color:#64748b;">
        <strong style="color:#374151;">Comptes de test :</strong><br>
        👑 Admin : <code>admin@shop.com</code> / <code>admin123</code><br>
        👤 User &nbsp;: <code>user@shop.com</code> / <code>user123</code>
    </div>
</div>
</body>
</html>
