USE nutriplan;

-- =========================================================
-- USERS TEST
-- =========================================================

INSERT INTO users (
    nom,
    prenom,
    genre,
    email,
    password_hash,
    taille,
    poids,
    is_gold,
    wallet_balance,
    role
)
VALUES
(
    'Rakoto',
    'Jean',
    'H',
    'jean@test.com',
    '123456',
    175,
    70,
    FALSE,
    50000,
    'user'
),
(
    'Rasoanaivo',
    'Marie',
    'F',
    'marie@test.com',
    '123456',
    165,
    58,
    TRUE,
    120000,
    'user'
),
(
    'Admin',
    'Root',
    'H',
    'admin@nutriplan.com',
    'admin123',
    180,
    75,
    TRUE,
    999999,
    'admin'
);

-- =========================================================
-- REGIMES TEST
-- =========================================================

INSERT INTO regimes (
    nom,
    description,
    objectif,
    pct_viande,
    pct_poisson,
    pct_volaille,
    calories_jour,
    duree_moyenne
)
VALUES
(
    'Regime Keto',
    'Faible glucide',
    'perte',
    50,
    20,
    30,
    1800,
    30
),
(
    'Prise Masse',
    'Hypercalorique muscle',
    'prise',
    40,
    30,
    30,
    3200,
    90
),
(
    'Equilibre',
    'Nutrition equilibree',
    'equilibre',
    33,
    33,
    34,
    2200,
    60
);

-- =========================================================
-- SPORTS TEST
-- =========================================================

INSERT INTO sports (
    nom,
    description,
    difficulte,
    calories_brulees,
    duree_min,
    frequence_semaine
)
VALUES
(
    'Course',
    'Running cardio',
    'moyen',
    500,
    45,
    4
),
(
    'Musculation',
    'Travail musculaire',
    'difficile',
    650,
    60,
    5
),
(
    'Yoga',
    'Relaxation et souplesse',
    'facile',
    200,
    40,
    3
);

-- =========================================================
-- ASSOCIATIONS REGIME / SPORT
-- =========================================================

INSERT INTO regime_sports (
    regime_id,
    sport_id
)
VALUES
(1,1),
(1,3),
(2,2),
(3,1),
(3,3);

-- =========================================================
-- PRIX REGIMES
-- =========================================================

INSERT INTO prix_regime (
    regime_id,
    duree_mois,
    prix
)
VALUES
(1,1,30000),
(1,3,80000),
(2,1,45000),
(2,3,120000),
(3,1,25000);

-- =========================================================
-- SUBSCRIPTIONS TEST
-- =========================================================

INSERT INTO subscriptions (
    user_id,
    regime_id,
    duree_mois,
    prix_paye,
    date_debut,
    date_fin
)
VALUES
(
    1,
    1,
    1,
    30000,
    '2026-05-01',
    '2026-06-01'
),
(
    2,
    2,
    3,
    120000,
    '2026-05-01',
    '2026-08-01'
);

-- =========================================================
-- HISTORIQUE POIDS TEST
-- =========================================================

INSERT INTO weight_history (
    user_id,
    poids,
    date_mesure
)
VALUES
(1,70,'2026-05-01'),
(1,69,'2026-05-05'),
(2,58,'2026-05-01'),
(2,59,'2026-05-05');

-- =========================================================
-- CODES TEST
-- =========================================================

INSERT INTO codes (
    code,
    valeur,
    is_used
)
VALUES
('NP100',10000,FALSE),
('NP200',20000,FALSE),
('NP500',50000,FALSE),
('GOLD50',50000,FALSE),
('VIP100',100000,FALSE);

-- =========================================================
-- CONFIG SYSTEM TEST
-- =========================================================

INSERT INTO config_system (
    cle,
    valeur
)
VALUES
('gold_price','50000'),
('gold_discount','15'),
('imc_min','18.5'),
('imc_max','25');