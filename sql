CREATE DATABASE IF NOT EXISTS shop
  CHARACTER SET utf8
  COLLATE utf8_unicode_ci;

USE shop;

CREATE TABLE IF NOT EXISTS categories (
    id  INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS products (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    nom          VARCHAR(100)   NOT NULL,
    prix         DECIMAL(10,2)  NOT NULL DEFAULT 0,
    quantite     INT            NOT NULL DEFAULT 0,
    image        VARCHAR(255)   DEFAULT 'default.png',
    categorie_id INT,
    FOREIGN KEY (categorie_id)
        REFERENCES categories(id)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS users (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(100)  NOT NULL,
    email      VARCHAR(150)  NOT NULL UNIQUE,
    password   VARCHAR(255)  NOT NULL,
    role       ENUM('admin','user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS commandes (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT IGNORE INTO categories (nom) VALUES
    ('Laptop'),
    ('Phone'),
    ('Accessoires');

INSERT IGNORE INTO products (nom, prix, quantite, image, categorie_id) VALUES
    ('Dell XPS 15',    1500.00, 10, 'default.png', 1),
    ('MacBook Pro 14', 2500.00,  5, 'default.png', 1),
    ('iPhone 15 Pro',  1200.00, 20, 'default.png', 2),
    ('Samsung S24',     950.00, 15, 'default.png', 2),
    ('AirPods Pro',     350.00, 30, 'default.png', 3);


--  DATA — USERS  (passwords hashed)
--  admin@shop.com  →  admin123
--  user@shop.com   →  user123

INSERT IGNORE INTO users (name, email, password, role) VALUES
(
  'Administrateur',
  'admin@shop.com',
  '$2b$10$HTHywW.culQNAMUnVjej9e3MiBwt4PAJwoh3ICq1K557KcdOb4WRi',
  'admin'
),
(
  'Utilisateur',
  'user@shop.com',
  '$2b$10$RJXGvSddbC.0uQXY5e/g0ueW.iDskGfyPrWTkrIbUk0eRqNQbWXjK',
  'user'
);
