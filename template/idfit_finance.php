<meta charset="UTF-8">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<link rel="stylesheet" href="css/header.css">
<link rel="stylesheet" href="css/idfit_finance.css">
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
      <a class="uh-link" href="idfit_dashboard_user.php">
        <i class="ti ti-home" aria-hidden="true"></i>
        Dashboard
      </a>
      <a class="uh-link" href="idfit_regimes.php">
        <i class="ti ti-salad" aria-hidden="true"></i>
        R&eacute;gimes
      </a>
      <a class="uh-link is-active" href="idfit_finance.php">
        <i class="ti ti-wallet" aria-hidden="true"></i>
        Portefeuille
      </a>
      <a class="uh-link" href="#">
        <i class="ti ti-chart-line" aria-hidden="true"></i>
        Graphique
      </a>
    </nav>

    <div class="uh-actions">
      <a class="uh-wallet" href="idfit_finance.php" title="Solde disponible">
        <i class="ti ti-coins" aria-hidden="true"></i>
        <span data-wallet-balance><?= number_format($walletBalance ?? 0, 0, ',', ' ') ?> Ar</span>
      </a>
      <a class="uh-wallet uh-gold" href="idfit_finance.php" title="Option Gold">
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
    <div class="sb-item" onclick="location.href='idfit_dashboard_user.php'"><i class="ti ti-home" aria-hidden="true"></i> Dashboard</div>
    <div class="sb-item" onclick="location.href='idfit_regimes.php'"><i class="ti ti-salad" aria-hidden="true"></i> Régimes</div>
    <div class="sb-item"><i class="ti ti-chart-line" aria-hidden="true"></i> Graphique</div>
    <div class="sb-section">Finance</div>
    <div class="sb-item on"><i class="ti ti-wallet" aria-hidden="true"></i> Portefeuille</div>
    <div class="sb-item" onclick="location.href='idfit_finance.php'"><i class="ti ti-star" aria-hidden="true"></i> Option Gold</div>
    <div class="sb-bottom">
      <div class="u-style-22">
        <div class="sb-av"><?= strtoupper(substr($userFirstName ?? 'U', 0, 1) . substr($userLastName ?? '', 0, 1)) ?></div>
        <div><div class="sb-name"><?= esc($userFirstName ?? 'User') ?></div><div class="sb-role"><?= ($isGold ?? false) ? 'Membre Gold' : 'Membre' ?></div></div>
      </div>
    </div>
  </div>

  <div class="main">
    <div class="grid2">
      <div class="card">
        <div class="card-title"><i class="ti ti-wallet u-style-23" aria-hidden="true"></i> Mon portefeuille</div>
        <div class="wallet-hero">
          <div class="w-label">Solde disponible</div>
          <div class="w-amount"><span id="wallet-balance">0</span> <span class="w-unit">Ar</span></div>
          <div class="w-status"><i class="ti ti-circle-x u-style-1" aria-hidden="true"></i> Compte Gold inactif</div>
        </div>
        <label class="flabel">Entrer un code de recharge</label>
        <div class="inp-row">
          <input id="wallet-code" class="inp" placeholder="" maxlength="14">
          <button id="wallet-credit" class="btn-enc"><i class="ti ti-coins" aria-hidden="true"></i> Encaisser</button>
        </div>
        <div class="u-style-24">
          <i class="ti ti-info-circle u-style-1" aria-hidden="true"></i> Les codes sont à usage unique et non remboursables
        </div>
        <div class="flabel">Historique des transactions</div>
        <div class="tx-list">
          <div class="tx-empty">Aucune transaction pour le moment.</div>
        </div>
      </div>

      <div>
        <div class="gold-card">
          <div class="gc-head">
            <div class="gc-ico"><i class="ti ti-star u-style-31" aria-hidden="true"></i></div>
            <div><div class="gc-title">IdFit Gold</div><div class="gc-sub">Accès illimité aux avantages premium</div></div>
          </div>
          <div class="gc-perks">
            <div class="perk"><i class="ti ti-discount" aria-hidden="true"></i> 15% de remise sur tous les régimes</div>
            <div class="perk"><i class="ti ti-file-export" aria-hidden="true"></i> Export PDF illimité</div>
            <div class="perk"><i class="ti ti-chart-bar" aria-hidden="true"></i> Statistiques avancées</div>
            <div class="perk"><i class="ti ti-headset" aria-hidden="true"></i> Support prioritaire</div>
            <div class="perk"><i class="ti ti-infinity" aria-hidden="true"></i> Accès à vie (paiement unique)</div>
          </div>
          <div class="gc-price">
            <span class="gp-val">20 000</span>
            <span class="gp-unit">Ar</span>
            <span class="gp-type">— paiement unique</span>
          </div>
          <button id="gold-action" class="btn-gold" data-action="upgradeToGold"><i class="ti ti-star" aria-hidden="true"></i> Devenir Gold</button>
        </div>
      </div>
    </div>
  </div>
</div>
