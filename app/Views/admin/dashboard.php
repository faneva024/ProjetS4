<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriPlan - Admin Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 24px; background: #f6f7fb; }
        .cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 24px; }
        .card { background: #fff; border-radius: 10px; padding: 16px; box-shadow: 0 2px 8px rgba(0,0,0,.08); }
        .label { color: #677083; font-size: 13px; margin-bottom: 6px; }
        .value { font-size: 28px; font-weight: 700; color: #18243d; }
        .actions a { margin-right: 12px; color: #0a58ca; text-decoration: none; }
    </style>
</head>
<body>
    <h1>Dashboard Admin</h1>

    <div class="cards">
        <div class="card">
            <div class="label">Utilisateurs</div>
            <div class="value"><?= esc((string) ($total_users ?? 0)) ?></div>
        </div>
        <div class="card">
            <div class="label">Comptes Gold</div>
            <div class="value"><?= esc((string) ($total_gold ?? 0)) ?></div>
        </div>
        <div class="card">
            <div class="label">Abonnements</div>
            <div class="value"><?= esc((string) ($total_subscriptions ?? 0)) ?></div>
        </div>
    </div>

    <div class="actions">
        <a href="/admin/regimes">Gerer les regimes</a>
        <a href="/admin/sports">Gerer les sports</a>
    </div>
</body>
</html>
