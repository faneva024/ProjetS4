<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriPlan - Accueil</title>
    <style>
        :root {
            --bg: #0f1220;
            --panel: #1b2140;
            --card: #222a52;
            --text: #f2f5ff;
            --muted: #bcc3e0;
            --primary: #f3b33f;
            --accent: #77d5ff;
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text);
            background: radial-gradient(circle at top right, #2f3f84 0%, var(--bg) 60%);
            min-height: 100vh;
        }

        .wrap {
            max-width: 1000px;
            margin: 0 auto;
            padding: 28px 18px 40px;
        }

        .hero {
            background: linear-gradient(135deg, #1a2452, #101a3a);
            border: 1px solid #33407a;
            border-radius: 18px;
            padding: 26px;
            margin-bottom: 20px;
            box-shadow: 0 10px 26px rgba(0, 0, 0, 0.28);
        }

        h1 {
            margin: 0 0 8px;
            font-size: 34px;
            line-height: 1.15;
        }

        p {
            margin: 0;
            color: var(--muted);
            font-size: 16px;
            line-height: 1.55;
        }

        .actions {
            margin-top: 18px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .btn {
            display: inline-block;
            text-decoration: none;
            font-weight: 700;
            padding: 10px 14px;
            border-radius: 10px;
            border: 1px solid transparent;
        }

        .btn-primary {
            color: #1a1630;
            background: var(--primary);
        }

        .btn-secondary {
            color: var(--text);
            border-color: #4860b0;
            background: transparent;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 12px;
        }

        .card {
            background: var(--card);
            border: 1px solid #3b4d8f;
            border-radius: 14px;
            padding: 14px;
        }

        .card h3 {
            margin: 0 0 8px;
            font-size: 17px;
            color: var(--accent);
        }

        .card a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
        }

        .card a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="wrap">
        <section class="hero">
            <h1>NutriPlan est bien lance</h1>
            <p>
                Cette page confirme que votre application fonctionne.
                Vous pouvez maintenant acceder aux modules utilitaires et API.
            </p>
            <div class="actions">
                <a class="btn btn-primary" href="/admin">Ouvrir Admin</a>
                <a class="btn btn-secondary" href="/api/imc">Tester API IMC (connecte)</a>
            </div>
        </section>

        <section class="grid">
            <article class="card">
                <h3>Authentification API</h3>
                <a href="/api/login">POST /api/login</a>
            </article>
            <article class="card">
                <h3>Profil API</h3>
                <a href="/api/profile">GET /api/profile</a>
            </article>
            <article class="card">
                <h3>Suggestions API</h3>
                <a href="/api/regimes/suggestions">GET /api/regimes/suggestions</a>
            </article>
            <article class="card">
                <h3>Poids API</h3>
                <a href="/api/weight-history">GET /api/weight-history</a>
            </article>
        </section>
    </div>
</body>
</html>
