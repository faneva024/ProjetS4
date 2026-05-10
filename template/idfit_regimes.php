<meta charset="UTF-8">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<link rel="stylesheet" href="css/header.css">
<link rel="stylesheet" href="css/idfit_regimes.css">
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
      <a class="uh-link is-active" href="idfit_regimes.php">
        <i class="ti ti-salad" aria-hidden="true"></i>
        R&eacute;gimes
      </a>
      <a class="uh-link" href="idfit_finance.php">
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
    <div class="sb-item on"><i class="ti ti-salad" aria-hidden="true"></i> Régimes</div>
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
    <div class="page-header">
      <div class="page-title">Régimes disponibles</div>
      <div class="page-sub">5 programmes personnalisés selon votre objectif</div>
    </div>

    <div class="gold-banner">
      <div class="gold-ico"><i class="ti ti-star u-style-37" aria-hidden="true"></i></div>
      <div class="gold-txt">
        <div class="gold-title">Vous êtes membre Gold <i class="ti ti-circle-check u-style-38" aria-hidden="true"></i></div>
        <div class="gold-desc">15% de remise appliquée sur tous les régimes automatiquement</div>
      </div>
    </div>

    <div class="filters">
      <button class="filter-chip on">Tous</button>
      <button class="filter-chip">Réduire le poids</button>
      <button class="filter-chip">Augmenter le poids</button>
      <button class="filter-chip">IMC idéal</button>
    </div>

    <div class="cards">
      <div class="rcard active-plan">
        <div class="active-tag">Mon régime actif</div>
        <div class="rc-head">
          <div class="rc-ico u-style-16"><i class="ti ti-fish u-style-39" aria-hidden="true"></i></div>
          <div>
            <div class="rc-name">Régime Méditerranéen</div>
            <div class="rc-obj"><span class="obj-badge u-style-40">Réduire le poids</span></div>
          </div>
        </div>
        <div class="macros">
          <div class="mac"><div class="mac-v">30%</div><div class="mac-l">Viande</div></div>
          <div class="mac"><div class="mac-v">40%</div><div class="mac-l">Poisson</div></div>
          <div class="mac"><div class="mac-v">30%</div><div class="mac-l">Volaille</div></div>
        </div>
        <div class="sports">
          <span class="sport-tag"><i class="ti ti-run u-style-8" aria-hidden="true"></i> Cardio 3×/sem</span>
          <span class="sport-tag"><i class="ti ti-swim u-style-8" aria-hidden="true"></i> Natation 2×/sem</span>
        </div>
        <div class="u-style-41">2 100 kcal/jour · Perte estimée −1.5 kg/mois · Durée 3 mois</div>
        <div class="price-row">
          <div>
            <div class="price-block">
              <span class="price-orig">53 000 Ar</span>
              <span class="price-final">45 000</span>
              <span class="price-dur">Ar/mois</span>
            </div>
            <span class="discount">−15% Gold</span>
          </div>
          <div class="btn-row">
            <button class="btn-sub"><i class="ti ti-check" aria-hidden="true"></i> Souscrit</button>
            <button class="btn-pdf" data-prompt="Exporter PDF régime IdFit"><i class="ti ti-file-export" aria-hidden="true"></i> PDF</button>
          </div>
        </div>
      </div>

      <div class="rcard">
        <div class="rc-head">
          <div class="rc-ico u-style-42"><i class="ti ti-leaf u-style-43" aria-hidden="true"></i></div>
          <div>
            <div class="rc-name">Régime Végétarien</div>
            <div class="rc-obj"><span class="obj-badge u-style-40">Réduire le poids</span></div>
          </div>
        </div>
        <div class="macros">
          <div class="mac"><div class="mac-v">0%</div><div class="mac-l">Viande</div></div>
          <div class="mac"><div class="mac-v">20%</div><div class="mac-l">Poisson</div></div>
          <div class="mac"><div class="mac-v">0%</div><div class="mac-l">Volaille</div></div>
        </div>
        <div class="sports">
          <span class="sport-tag"><i class="ti ti-bike u-style-8" aria-hidden="true"></i> Vélo 3×/sem</span>
          <span class="sport-tag"><i class="ti ti-walk u-style-8" aria-hidden="true"></i> Marche 5×/sem</span>
        </div>
        <div class="u-style-41">1 800 kcal/jour · Perte estimée −1.2 kg/mois · Durée 4 mois</div>
        <div class="price-row">
          <div>
            <div class="price-block">
              <span class="price-orig">42 000 Ar</span>
              <span class="price-final">35 700</span>
              <span class="price-dur">Ar/mois</span>
            </div>
            <span class="discount">−15% Gold</span>
          </div>
          <div class="btn-row">
            <button class="btn-sub"><i class="ti ti-shopping-cart" aria-hidden="true"></i> Souscrire</button>
            <button class="btn-pdf"><i class="ti ti-file-export" aria-hidden="true"></i> PDF</button>
          </div>
        </div>
      </div>

      <div class="rcard">
        <div class="rc-head">
          <div class="rc-ico u-style-29"><i class="ti ti-meat u-style-44" aria-hidden="true"></i></div>
          <div>
            <div class="rc-name">Régime Hyperprotéiné</div>
            <div class="rc-obj"><span class="obj-badge u-style-45">Augmenter le poids</span></div>
          </div>
        </div>
        <div class="macros">
          <div class="mac"><div class="mac-v">50%</div><div class="mac-l">Viande</div></div>
          <div class="mac"><div class="mac-v">20%</div><div class="mac-l">Poisson</div></div>
          <div class="mac"><div class="mac-v">30%</div><div class="mac-l">Volaille</div></div>
        </div>
        <div class="sports">
          <span class="sport-tag"><i class="ti ti-barbell u-style-8" aria-hidden="true"></i> Muscu 4×/sem</span>
        </div>
        <div class="u-style-41">3 200 kcal/jour · Gain estimé +2 kg/mois · Durée 3 mois</div>
        <div class="price-row">
          <div>
            <div class="price-block">
              <span class="price-orig">65 000 Ar</span>
              <span class="price-final">55 250</span>
              <span class="price-dur">Ar/mois</span>
            </div>
            <span class="discount">−15% Gold</span>
          </div>
          <div class="btn-row">
            <button class="btn-sub"><i class="ti ti-shopping-cart" aria-hidden="true"></i> Souscrire</button>
            <button class="btn-pdf"><i class="ti ti-file-export" aria-hidden="true"></i> PDF</button>
          </div>
        </div>
      </div>

      <div class="rcard">
        <div class="rc-head">
          <div class="rc-ico u-style-46"><i class="ti ti-heart u-style-47" aria-hidden="true"></i></div>
          <div>
            <div class="rc-name">Régime Équilibré IMC</div>
            <div class="rc-obj"><span class="obj-badge u-style-48">IMC idéal</span></div>
          </div>
        </div>
        <div class="macros">
          <div class="mac"><div class="mac-v">35%</div><div class="mac-l">Viande</div></div>
          <div class="mac"><div class="mac-v">35%</div><div class="mac-l">Poisson</div></div>
          <div class="mac"><div class="mac-v">30%</div><div class="mac-l">Volaille</div></div>
        </div>
        <div class="sports">
          <span class="sport-tag"><i class="ti ti-yoga u-style-8" aria-hidden="true"></i> Yoga 3×/sem</span>
          <span class="sport-tag"><i class="ti ti-run u-style-8" aria-hidden="true"></i> Jogging 2×/sem</span>
        </div>
        <div class="u-style-41">2 400 kcal/jour · IMC cible 22 · Durée 6 mois</div>
        <div class="price-row">
          <div>
            <div class="price-block">
              <span class="price-orig">58 000 Ar</span>
              <span class="price-final">49 300</span>
              <span class="price-dur">Ar/mois</span>
            </div>
            <span class="discount">−15% Gold</span>
          </div>
          <div class="btn-row">
            <button class="btn-sub"><i class="ti ti-shopping-cart" aria-hidden="true"></i> Souscrire</button>
            <button class="btn-pdf"><i class="ti ti-file-export" aria-hidden="true"></i> PDF</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
