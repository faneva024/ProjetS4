<?php
/** @var array $data */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IdFit - Dashboard</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

  <link rel="stylesheet" href="/template/css/header.css">
  <link rel="stylesheet" href="/template/css/idfit_dashboard_user.css">
  <link rel="stylesheet" href="/template/css/inline.css">
</head>

<body>
  <!-- CONTENT -->
  <header class="user-header-wrap">
    <div class="user-header">
      <a class="uh-brand" href="/dashboard" aria-label="Accueil IdFit">
        <span class="uh-logo-mark">
          <img src="/template/image/logo.png" alt="IdFit">
        </span>
        <span class="uh-logo-text">
          <span class="uh-status">
            <i class="ti ti-star-filled" aria-hidden="true"></i>
            <?= !empty($data['isGold']) ? 'Gold actif' : 'Gold inactif' ?>
          </span>
        </span>
      </a>

      <nav class="uh-nav" aria-label="Navigation utilisateur">
        <a class="uh-link is-active" href="/dashboard">
          <i class="ti ti-home" aria-hidden="true"></i>
          Dashboard
        </a>
        <a class="uh-link" href="/regimes">
          <i class="ti ti-salad" aria-hidden="true"></i>
          Régimes
        </a>
        <a class="uh-link" href="/finance">
          <i class="ti ti-wallet" aria-hidden="true"></i>
          Portefeuille
        </a>
        <a class="uh-link" href="#">
          <i class="ti ti-chart-line" aria-hidden="true"></i>
          Graphique
        </a>
      </nav>

      <div class="uh-actions">
        <a class="uh-wallet" href="/finance" title="Solde disponible">
          <i class="ti ti-coins" aria-hidden="true"></i>
          <span data-wallet-balance><?= htmlspecialchars((string)($data['walletBalance'] ?? 0), ENT_QUOTES, 'UTF-8') ?> Ar</span>
        </a>
        <a class="uh-wallet uh-gold" href="/finance" title="Option Gold">
          <i class="ti ti-crown" aria-hidden="true"></i>
          <span>Gold</span>
        </a>
      </div>
    </div>
  </header>

  <div class="layout">
    <div class="sidebar">
      <div class="sb-logo">IdFit <span class="gold-badge">GOLD</span></div>
      <div class="sb-section">Principal</div>
      <div class="sb-item on"><i class="ti ti-home" aria-hidden="true"></i> Dashboard</div>
      <div class="sb-item" data-prompt="Montre-moi la page régimes IdFit"><i class="ti ti-salad" aria-hidden="true"></i> Régimes</div>
      <div class="sb-item"><i class="ti ti-chart-line" aria-hidden="true"></i> Graphique</div>

      <div class="sb-section">Finance</div>
      <div class="sb-item" data-prompt="Montre-moi la page portefeuille IdFit"><i class="ti ti-wallet" aria-hidden="true"></i> Portefeuille</div>
      <div class="sb-item" data-prompt="Montre-moi la page option Gold IdFit"><i class="ti ti-star" aria-hidden="true"></i> Option Gold</div>

      <div class="sb-bottom">
        <div class="sb-user">
          <div class="sb-av">FR</div>
          <div>
            <div class="sb-name"><?= htmlspecialchars((string)($data['userFirstName'] ?? 'Utilisateur'), ENT_QUOTES, 'UTF-8') ?></div>
            <div class="sb-role"><?= !empty($data['isGold']) ? 'Membre Gold' : 'Membre' ?></div>
          </div>
        </div>
      </div>
    </div>

    <div class="main">
      <div class="topbar">
        <div>
          <div class="page-title">Bonjour, <?= htmlspecialchars((string)($data['userFirstName'] ?? ''), ENT_QUOTES, 'UTF-8') ?> 👋</div>
          <div class="page-sub">Programme personnalisé</div>
        </div>
        <div class="topbar-right">
          <div class="wallet">
            <i class="ti ti-wallet" aria-hidden="true"></i>
            <span data-wallet-balance><?= htmlspecialchars((string)($data['walletBalance'] ?? 0), ENT_QUOTES, 'UTF-8') ?> Ar</span>
          </div>
        </div>
      </div>

      <div class="metrics">
        <div class="met">
          <div class="met-label"><i class="ti ti-weight u-style-1" aria-hidden="true"></i> Poids actuel</div>
          <div class="met-val met-accent">
            <?= htmlspecialchars(number_format((float)($data['poids'] ?? 0), 1, '.', ''), ENT_QUOTES, 'UTF-8') ?>
            <span class="u-style-12">kg</span>
          </div>
          <div class="met-sub">▼ —</div>
        </div>

        <div class="met">
          <div class="met-label"><i class="ti ti-target u-style-1" aria-hidden="true"></i> Objectif</div>
          <div class="met-val u-style-13"><?= htmlspecialchars((string)($data['objectiveLabel'] ?? 'IMC idéal'), ENT_QUOTES, 'UTF-8') ?></div>
          <div class="met-sub">Cible : <?= htmlspecialchars(number_format((float)($data['idealWeight'] ?? 0), 1, '.', ''), ENT_QUOTES, 'UTF-8') ?> kg</div>
        </div>

        <div class="met">
          <div class="met-label"><i class="ti ti-flame u-style-1" aria-hidden="true"></i> Calories/jour</div>
          <div class="met-val met-amber">—</div>
          <div class="met-sub">kcal recommandées</div>
        </div>

        <div class="met">
          <div class="met-label"><i class="ti ti-activity u-style-1" aria-hidden="true"></i> IMC actuel</div>
          <div class="met-val met-amber"><?= htmlspecialchars(number_format((float)($data['imc'] ?? 0), 1, '.', ''), ENT_QUOTES, 'UTF-8') ?></div>
          <div class="met-sub">—</div>
        </div>
      </div>

      <div class="grid2">
        <div class="card">
          <div class="card-head">
            <div class="card-title">Évolution du poids</div>
            <span class="card-action">Voir tout</span>
          </div>
          <div class="chart-wrap">
            <canvas id="weightChart"></canvas>
          </div>
        </div>

        <div class="card">
          <div class="card-head">
            <div class="card-title">Enregistrer mon poids</div>
          </div>

          <!-- Form POST (MVC) -->
          <form class="insert-form" method="post" action="/api/weight">
            <div>
              <label class="flabel">Poids du jour</label>
              <div class="u-style-14">
                <input id="weight-value" class="inp" name="poids" type="number" step="0.1" value="<?= htmlspecialchars((string)($data['poids'] ?? 0), ENT_QUOTES, 'UTF-8') ?>" />
                <span class="u-style-15">kg</span>
              </div>
            </div>

            <div>
              <label class="flabel">Date</label>
              <input id="weight-date" class="inp" name="date_mesure" type="date" value="<?= date('Y-m-d') ?>">
            </div>

            <div>
              <label class="flabel">Note (optionnel)</label>
              <input id="weight-note" class="inp" placeholder="Ex : après sport..." name="note">
            </div>

            <button class="btn-save" type="submit">
              <i class="ti ti-device-floppy" aria-hidden="true"></i> Enregistrer
            </button>
          </form>
        </div>
      </div>

    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
  <script src="/template/js/idfit_app.js"></script>
</body>
</html>
