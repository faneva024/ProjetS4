<?php
/** @var array $data */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IdFit - Finance</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

  <link rel="stylesheet" href="/template/css/header.css">
  <link rel="stylesheet" href="/template/css/idfit_finance.css">
  <link rel="stylesheet" href="/template/css/inline.css">
</head>
<body>

<header class="user-header-wrap">
  <div class="user-header">
    <a class="uh-brand" href="/finance" aria-label="Portefeuille IdFit">
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
      <a class="uh-link" href="/dashboard"><i class="ti ti-home" aria-hidden="true"></i> Dashboard</a>
      <a class="uh-link" href="/regimes"><i class="ti ti-salad" aria-hidden="true"></i> Régimes</a>
      <a class="uh-link is-active" href="/finance"><i class="ti ti-wallet" aria-hidden="true"></i> Portefeuille</a>
      <a class="uh-link" href="#"><i class="ti ti-chart-line" aria-hidden="true"></i> Graphique</a>
    </nav>

    <div class="uh-actions">
      <a class="uh-wallet" href="/finance" title="Solde disponible">
        <i class="ti ti-coins" aria-hidden="true"></i>
        <span>
          <?= htmlspecialchars(number_format((float)($data['walletBalance'] ?? 0), 0, ',', ' '), ENT_QUOTES, 'UTF-8') ?> Ar
        </span>
      </a>
      <a class="uh-wallet uh-gold" href="/finance" title="Option Gold">
        <i class="ti ti-crown" aria-hidden="true"></i>
        <span>Gold</span>
      </a>
    </div>
  </div>
</header>

<main class="layout">
  <div class="main">
    <div class="grid2">
      <section class="card" aria-label="Recharge portefeuille">
        <div class="card-title">
          <i class="ti ti-wallet u-style-23" aria-hidden="true"></i> Mon portefeuille
        </div>

        <div class="wallet-hero">
          <div class="w-label">Solde disponible</div>
          <div class="w-amount">
            <span><?= htmlspecialchars(number_format((float)($data['walletBalance'] ?? 0), 0, ',', ' '), ENT_QUOTES, 'UTF-8') ?></span>
            <span class="w-unit">Ar</span>
          </div>

          <div class="w-status">
            <?php if (!empty($data['isGold'])): ?>
              <i class="ti ti-circle-check u-style-1" aria-hidden="true"></i> Compte Gold actif
            <?php else: ?>
              <i class="ti ti-circle-x u-style-1" aria-hidden="true"></i> Compte Gold inactif
            <?php endif; ?>
          </div>
        </div>

        <?php
          // Les contrôleurs WalletController/GoldController renvoient du JSON en cas d’erreur.
          // Ici on laisse les formulaires simples pour déclencher les actions via POST.
        ?>

        <form class="recharge-form" method="post" action="/wallet/recharge">
          <label class="flabel" for="wallet-code">Entrer un code de recharge</label>
          <div class="inp-row">
            <input id="wallet-code" class="inp" name="code" placeholder="" maxlength="14">
            <button class="btn-enc" type="submit">
              <i class="ti ti-coins" aria-hidden="true"></i> Encaisser
            </button>
          </div>
          <div class="u-style-24">
            <i class="ti ti-info-circle u-style-1" aria-hidden="true"></i>
            Les codes sont à usage unique et non remboursables
          </div>
        </form>

        <div class="flabel">Historique des transactions</div>
        <div class="tx-list">
          <div class="tx-empty">Historique en cours de migration (à brancher sur RechargeHistoryModel).</div>
        </div>
      </section>

      <aside>
        <div class="gold-card">
          <div class="gc-head">
            <div class="gc-ico"><i class="ti ti-star u-style-31" aria-hidden="true"></i></div>
            <div>
              <div class="gc-title">IdFit Gold</div>
              <div class="gc-sub">Accès illimité aux avantages premium</div>
            </div>
          </div>

          <div class="gc-perks">
            <div class="perk"><i class="ti ti-discount" aria-hidden="true"></i> 15% de remise sur tous les régimes</div>
            <div class="perk"><i class="ti ti-file-export" aria-hidden="true"></i> Export PDF illimité</div>
            <div class="perk"><i class="ti ti-chart-bar" aria-hidden="true"></i> Statistiques avancées</div>
            <div class="perk"><i class="ti ti-headset" aria-hidden="true"></i> Support prioritaire</div>
            <div class="perk"><i class="ti ti-infinity" aria-hidden="true"></i> Accès à vie (paiement unique)</div>
          </div>

          <div class="gc-price">
            <span class="gp-val">—</span>
            <span class="gp-unit">Ar</span>
            <span class="gp-type">— paiement unique</span>
          </div>

          <form method="post" action="/gold/upgrade">
            <button id="gold-action" class="btn-gold" type="submit" <?= !empty($data['isGold']) ? 'disabled' : '' ?>>
              <i class="ti ti-star" aria-hidden="true"></i>
              <?= !empty($data['isGold']) ? 'Gold activé' : 'Devenir Gold' ?>
            </button>
          </form>
        </div>
      </aside>
    </div>
  </div>
</main>

</body>
</html>
