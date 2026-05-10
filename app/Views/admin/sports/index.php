<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriPlan - Sports</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 24px; background: #f6f7fb; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { border-bottom: 1px solid #e5e9f0; padding: 10px; text-align: left; font-size: 14px; }
        th { background: #eef2f7; }
        form.inline { display: inline; }
        .panel { background: #fff; padding: 16px; margin-bottom: 16px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,.08); }
        .grid { display: grid; gap: 8px; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); }
        input, select, button { padding: 8px; }
        button { cursor: pointer; }
        .link { margin-bottom: 16px; display: inline-block; }
    </style>
</head>
<body>
    <a class="link" href="/admin">Retour dashboard</a>
    <h1>Gestion des sports</h1>

    <div class="panel">
        <h3>Nouveau sport</h3>
        <form method="post" action="/admin/sports">
            <div class="grid">
                <input type="text" name="nom" placeholder="Nom" required>
                <input type="text" name="description" placeholder="Description">
                <select name="difficulte" required>
                    <option value="facile">Facile</option>
                    <option value="moyen">Moyen</option>
                    <option value="difficile">Difficile</option>
                </select>
                <input type="number" name="calories_brulees" placeholder="Calories brulees" value="0">
                <input type="number" name="duree_min" placeholder="Duree (minutes)" value="30">
                <input type="number" name="frequence_semaine" placeholder="Frequence / semaine" value="3">
            </div>
            <p><button type="submit">Ajouter</button></p>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Difficulte</th>
                <th>Calories</th>
                <th>Duree</th>
                <th>Frequence</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (($sports ?? []) as $sport): ?>
                <tr>
                    <td><?= esc((string) $sport['id']) ?></td>
                    <td><?= esc($sport['nom']) ?></td>
                    <td><?= esc($sport['difficulte']) ?></td>
                    <td><?= esc((string) $sport['calories_brulees']) ?></td>
                    <td><?= esc((string) $sport['duree_min']) ?></td>
                    <td><?= esc((string) $sport['frequence_semaine']) ?></td>
                    <td>
                        <form class="inline" method="post" action="/admin/sports/<?= esc((string) $sport['id']) ?>/delete" onsubmit="return confirm('Supprimer ce sport ?');">
                            <button type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
