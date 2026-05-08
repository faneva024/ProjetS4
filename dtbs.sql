-- =========================================================
-- BASE DE DONNEES : NUTRIPLAN
-- SGBD : MYSQL
-- =========================================================

DROP DATABASE IF EXISTS nutriplan;

CREATE DATABASE nutriplan
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE nutriplan;

-- =========================================================
-- TABLE USERS
-- =========================================================

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,

    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,

    genre ENUM('H','F') NOT NULL,

    email VARCHAR(150) NOT NULL UNIQUE,

    password_hash VARCHAR(255) NOT NULL,

    taille DECIMAL(5,2) NOT NULL,
    poids DECIMAL(5,2) NOT NULL,

    is_gold BOOLEAN DEFAULT FALSE,

    wallet_balance DECIMAL(10,2) DEFAULT 0,

    role ENUM('user','admin') DEFAULT 'user',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================================================
-- TABLE REGIMES
-- =========================================================

CREATE TABLE regimes (
    id INT AUTO_INCREMENT PRIMARY KEY,

    nom VARCHAR(100) NOT NULL,

    description TEXT,

    objectif ENUM(
        'perte',
        'prise',
        'equilibre'
    ) NOT NULL,

    pct_viande DECIMAL(5,2) DEFAULT 0,
    pct_poisson DECIMAL(5,2) DEFAULT 0,
    pct_volaille DECIMAL(5,2) DEFAULT 0,

    calories_jour INT NOT NULL,

    duree_moyenne INT DEFAULT 30
);

-- =========================================================
-- TABLE SPORTS
-- =========================================================

CREATE TABLE sports (
    id INT AUTO_INCREMENT PRIMARY KEY,

    nom VARCHAR(100) NOT NULL,

    description TEXT,

    difficulte ENUM(
        'facile',
        'moyen',
        'difficile'
    ) DEFAULT 'facile',

    calories_brulees INT DEFAULT 0,

    duree_min INT DEFAULT 30,

    frequence_semaine INT DEFAULT 3
);

-- =========================================================
-- TABLE REGIME_SPORTS
-- =========================================================

CREATE TABLE regime_sports (
    id INT AUTO_INCREMENT PRIMARY KEY,

    regime_id INT NOT NULL,
    sport_id INT NOT NULL,

    FOREIGN KEY (regime_id)
        REFERENCES regimes(id)
        ON DELETE CASCADE,

    FOREIGN KEY (sport_id)
        REFERENCES sports(id)
        ON DELETE CASCADE
);

-- =========================================================
-- TABLE PRIX_REGIME
-- =========================================================

CREATE TABLE prix_regime (
    id INT AUTO_INCREMENT PRIMARY KEY,

    regime_id INT NOT NULL,

    duree_mois INT NOT NULL,

    prix DECIMAL(10,2) NOT NULL,

    FOREIGN KEY (regime_id)
        REFERENCES regimes(id)
        ON DELETE CASCADE
);

-- =========================================================
-- TABLE SUBSCRIPTIONS
-- =========================================================

CREATE TABLE subscriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT NOT NULL,
    regime_id INT NOT NULL,

    duree_mois INT NOT NULL,

    prix_paye DECIMAL(10,2) NOT NULL,

    date_debut DATE NOT NULL,

    date_fin DATE NOT NULL,

    FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE,

    FOREIGN KEY (regime_id)
        REFERENCES regimes(id)
        ON DELETE CASCADE
);

-- =========================================================
-- TABLE WEIGHT_HISTORY
-- =========================================================

CREATE TABLE weight_history (
    id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT NOT NULL,

    poids DECIMAL(5,2) NOT NULL,

    date_mesure DATE NOT NULL,

    FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);

-- =========================================================
-- TABLE CODES
-- =========================================================

CREATE TABLE codes (
    id INT AUTO_INCREMENT PRIMARY KEY,

    code VARCHAR(100) NOT NULL UNIQUE,

    valeur DECIMAL(10,2) NOT NULL,

    is_used BOOLEAN DEFAULT FALSE,

    used_by INT NULL,

    used_at TIMESTAMP NULL,

    FOREIGN KEY (used_by)
        REFERENCES users(id)
        ON DELETE SET NULL
);

-- =========================================================
-- TABLE CONFIG_SYSTEM
-- =========================================================

CREATE TABLE config_system (
    cle VARCHAR(100) PRIMARY KEY,

    valeur VARCHAR(255) NOT NULL
);

-- =========================================================
-- INDEX
-- =========================================================

CREATE INDEX idx_users_email
ON users(email);

CREATE INDEX idx_codes_code
ON codes(code);

CREATE INDEX idx_weight_user
ON weight_history(user_id);

CREATE INDEX idx_subscriptions_user
ON subscriptions(user_id);