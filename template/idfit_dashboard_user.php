<meta charset="UTF-8">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<link rel="stylesheet" href="css/header.css">
<link rel="stylesheet" href="css/idfit_dashboard_user.css">
  <link rel="stylesheet" href="css/inline.css">
<script src="js/idfit_app.js"></script>


<header class="user-header-wrap">
  <div class="user-header">
    <a class="uh-brand" href="idfit_dashboard_user.php" aria-label="Accueil IdFit">
      <span class="uh-logo-mark">
        <img src="image/logo.png" alt="IdFit">
      </span>
      <span class="uh-logo-text">
        <?php if ($isGold ?? false): ?>
          <span class="uh-status"><i class="ti ti-star-filled" aria-hidden="true"></i> Gold actif</span>
        <?php else: ?>
          <span class="uh-status" style="background: #e2e8f0; color: #475569;"><i class="ti ti-user" aria-hidden="true"></i> Standard</span>
        <?php endif; ?>
      </span>
    </a>

    <nav class="uh-nav" aria-label="Navigation utilisateur">
      <a class="uh-link is-active" href="idfit_dashboard_user.php">
        <i class="ti ti-home" aria-hidden="true"></i>
        Dashboard
      </a>
      <a class="uh-link" href="idfit_regimes.php">
        <i class="ti ti-salad" aria-hidden="true"></i>
        R&eacute;gimes
      </a>
      <a class="uh-link" href="idfit_finance.php">
        <i class="ti ti-wallet" aria-hidden="true"></i>
        Portefeuille
      </a>
      <a class="uh-link" href="#" data-prompt="Montre-moi mes graphiques IdFit">
        <i class="ti ti-chart-line" aria-hidden="true"></i>
        Graphique
      </a>
    </nav>

    <div class="uh-actions">
      <a class="uh-wallet" href="idfit_finance.php" title="Accéder au portefeuille">
        <i class="ti ti-coins" aria-hidden="true"></i>
        <span data-wallet-balance><?= number_format($walletBalance ?? 0, 0, ',', ' ') ?> Ar</span>
      </a>
      <a class="uh-wallet uh-gold" href="idfit_finance.php" title="Voir les avantages Gold">
        <i class="ti ti-crown" aria-hidden="true"></i>
        <span>Gold</span>
      </a>
      <div class="uh-profile" aria-label="Profil utilisateur">
        <div class="uh-profile-copy">
          <div class="uh-profile-name"><?= esc($userFirstName ?? 'User') ?> <?= esc(substr($userLastName ?? '', 0, 1)) ?>.</div>
          <div class="uh-profile-role"><?= ($isGold ?? false) ? 'Membre Gold' : 'Membre' ?></div>
        </div>
        <a href="/api/logout" class="uh-avatar" title="Se déconnecter" style="text-decoration: none;">
          <?= strtoupper(substr($userFirstName ?? 'U', 0, 1) . substr($userLastName ?? '', 0, 1)) ?>
        </a>
      </div>
    </div>
  </div>
</header>

<div class="layout">
  <div class="sidebar">
    <div class="sb-logo">IdFit <?php if ($isGold ?? false): ?><span class="gold-badge">GOLD</span><?php endif; ?></div>
    <div class="sb-section">Principal</div>
    <div class="sb-item on"><i class="ti ti-home" aria-hidden="true"></i> Dashboard</div>
    <div class="sb-item" onclick="location.href='idfit_regimes.php'"><i class="ti ti-salad" aria-hidden="true"></i> Régimes</div>
    <div class="sb-item"><i class="ti ti-chart-line" aria-hidden="true"></i> Graphique</div>
    <div class="sb-section">Finance</div>
    <div class="sb-item" onclick="location.href='idfit_finance.php'"><i class="ti ti-wallet" aria-hidden="true"></i> Portefeuille</div>
    <div class="sb-item" onclick="location.href='idfit_finance.php'"><i class="ti ti-star" aria-hidden="true"></i> Option Gold</div>
    <div class="sb-bottom">
      <div class="sb-user">
        <div class="sb-av"><?= strtoupper(substr($userFirstName ?? 'U', 0, 1) . substr($userLastName ?? '', 0, 1)) ?></div>
        <div><div class="sb-name"><?= esc($userFirstName ?? 'User') ?></div><div class="sb-role"><?= ($isGold ?? false) ? 'Membre Gold' : 'Membre' ?></div></div>
      </div>
    </div>
  </div>

  <div class="main">
    <div class="topbar">
      <div>
        <div class="page-title">Bonjour, Finaritra 👋</div>
        <div class="page-sub">Lundi 5 mai 2025 · Semaine 3 de votre programme</div>
      </div>
      <div class="topbar-right">
        <a href="idfit_finance.php" class="wallet" style="text-decoration: none;"><i class="ti ti-wallet" aria-hidden="true"></i> <span data-wallet-balance><?= number_format($walletBalance ?? 0, 0, ',', ' ') ?> Ar</span></a>
      </div>
    </div>

    <div class="metrics">
      <div class="met">
        <div class="met-label"><i class="ti ti-weight u-style-1" aria-hidden="true"></i> Poids actuel</div>
        <div class="met-val met-accent">85.2 <span class="u-style-12">kg</span></div>
        <div class="met-sub u-style-2">▼ −2.8 kg ce mois</div>
      </div>
      <div class="met">
        <div class="met-label"><i class="ti ti-target u-style-1" aria-hidden="true"></i> Objectif</div>
        <div class="met-val u-style-13">Réduire</div>
        <div class="met-sub">Cible : 67.5 kg</div>
      </div>
      <div class="met">
        <div class="met-label"><i class="ti ti-flame u-style-1" aria-hidden="true"></i> Calories/jour</div>
        <div class="met-val met-amber">2 100</div>
        <div class="met-sub">kcal recommandées</div>
      </div>
      <div class="met">
        <div class="met-label"><i class="ti ti-activity u-style-1" aria-hidden="true"></i> IMC actuel</div>
        <div class="met-val met-amber">27.8</div>
        <div class="met-sub">Surpoids modéré</div>
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
        <div class="card-head"><div class="card-title">Enregistrer mon poids</div></div>
        <div class="insert-form">
          <div>
            <label class="flabel">Poids du jour</label>
            <div class="u-style-14"><input id="weight-value" class="inp" value="85.2"><span class="u-style-15">kg</span></div>
          </div>
          <div>
            <label class="flabel">Date</label>
            <input id="weight-date" class="inp" type="date" value="2025-05-05">
          </div>
          <div>
            <label class="flabel">Note (optionnel)</label>
            <input id="weight-note" class="inp" placeholder="Ex : après sport...">
          </div>
          <button class="btn-save" data-action="updateWeightHistory"><i class="ti ti-device-floppy" aria-hidden="true"></i> Enregistrer</button>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-head">
        <div class="card-title">Mon régime actif</div>
        <span class="card-action" data-prompt="Montre-moi la page régimes IdFit">Changer de régime</span>
      </div>
      <div class="regime-item">
        <div class="regime-ico u-style-16"><i class="ti ti-salad u-style-17" aria-hidden="true"></i></div>
        <div>
          <div class="regime-name">Régime Méditerranéen</div>
          <div class="regime-sub">3 mois · 30% viande · 40% poisson · 30% volaille</div>
        </div>
        <div class="regime-price">-15% Gold</div>
      </div>
      <div class="u-style-18">
        <div class="u-style-19">
          <span>Progression semaine 3/12</span><span>25%</span>
        </div>
        <div class="u-style-20">
          <div class="u-style-21"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
<script src="js/idfit_dashboard_user.js"></script>
