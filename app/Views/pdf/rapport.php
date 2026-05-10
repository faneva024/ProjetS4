<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport NutriPlan</title>
    <style>
        body { font-family: Helvetica, Arial, sans-serif; color: #333; }
        h1 { color: #2c3e50; text-align: center; }
        .box { border: 1px solid #ddd; padding: 15px; margin-bottom: 20px; background: #f9f9f9; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
    </style>
</head>
<body>
    <h1>Rapport Santé - NutriPlan</h1>
    
    <div class="box">
        <h3>Profil de <?= esc($user['prenom']) ?> <?= esc($user['nom']) ?></h3>
        <p><strong>Taille :</strong> <?= esc($user['taille']) ?> cm</p>
        <p><strong>Poids actuel :</strong> <?= esc($user['poids']) ?> kg</p>
    </div>

    <div class="box">
        <h3>Analyse IMC</h3>
        <p><strong>Votre IMC :</strong> <?= esc($imc) ?></p>
        <p><strong>Catégorie :</strong> <?= ucfirst(esc($categorie)) ?></p>
        <p><strong>Poids idéal estimé :</strong> <?= esc($poids_ideal) ?> kg</p>
    </div>
</body>
</html>