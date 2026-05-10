<?php
/** @var array $data */
$regimes = $data['regimes'] ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IdFit - Régimes</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

  <link rel="stylesheet" href="/template/css/header.css">
  <link rel="stylesheet" href="/template/css/idfit_regimes.css">
  <link rel="stylesheet" href="/template/css/inline.css">
</head>
<body>
<header class="user-header-wrap">
  <div class="user-header">
    <a class="uh-brand" href="/regimes" aria-label="Régimes IdFit">
      <span class="uh-logo-mark">
        <img src="/template/image/logo.png" alt="IdFit">
      </span>
      <span class="uh-logo-text">
        <span class="uh-status"><i class="ti ti-star-filled" aria-hidden="true"></i> Gold</span>
      </span>
    </a>

    <nav class="uh-nav" aria-label="Navigation utilisateur">
      <a class="uh-link" href="/dashboard"><i class="ti ti-home" aria-hidden="true"></i> Dashboard</a>
      <a class="uh-link is-active" href="/regimes"><i class="ti ti-salad" aria-hidden="true"></i> Régimes</a>
      <a class="uh-link" href="/finance"><i class="ti ti-wallet" aria-hidden="true"></i> Portefeuille</a>
      <a class="uh-link" href="#"><i class="ti ti-chart-line" aria-hidden="true"></i> Graphique</a>
    </nav>

    <div class="uh-actions">
      <a class="uh-wallet" href="/finance" title="Solde disponible">
        <i class="ti ti-coins" aria-hidden="true"></i>
        <span data-wallet-balance>0 Ar</span>
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
    <div class="page-header">
      <div class="page-title">Régimes disponibles</div>
      <div class="page-sub"><?= count($regimes) ?> programmes trouvés</div>
    </div>

    <div class="cards">
      <?php if (empty($regimes)): ?>
        <div class="tx-empty">Aucun régime disponible.</div>
      <?php else: ?>
        <?php foreach ($regimes as $regime): ?>
          <?php
            $nom = (string)($regime['nom'] ?? '');
            $objectif = (string)($regime['objectif'] ?? '');
            $description = (string)($regime['description'] ?? '');
            $pctViande = (float)($regime['pct_viande'] ?? 0);
            $pctPoisson = (float)($regime['pct_poisson'] ?? 0);
            $pctVolaille = (float)($regime['pct_volaille'] ?? 0);
            $id = (int)($regime['id'] ?? 0);
          ?>
          <section class="rcard">
            <div class="rc-head">
              <div class="rc-name"><?= htmlspecialchars($nom, ENT_QUOTES, 'UTF-8') ?></div>
              <div class="rc-obj">
                <span class="obj-badge"><?= htmlspecialchars($objectif, ENT_QUOTES, 'UTF-8') ?></span>
              </div>
            </div>

            <div class="macros">
              <div class="mac"><div class="mac-v"><?= htmlspecialchars((string)$pctViande, ENT_QUOTES, 'UTF-8') ?>%</div><div class="mac-l">Viande</div></div>
              <div class="mac"><div class="mac-v"><?= htmlspecialchars((string)$pctPoisson, ENT_QUOTES, 'UTF-8') ?>%</div><div class="mac-l">Poisson</div></div>
              <div class="mac"><div class="mac-v"><?= htmlspecialchars((string)$pctVolaille, ENT_QUOTES, 'UTF-8') ?>%</div><div class="mac-l">Volaille</div></div>
            </div>

            <?php if ($description !== ''): ?>
              <div class="u-style-41" style="margin-top:8px;">
                <?= htmlspecialchars($description, ENT_QUOTES, 'UTF-8') ?>
              </div>
            <?php endif; ?>

            <div class="btn-row" style="margin-top:10px;">
              <!-- Placeholder actions: à migrer ensuite en MVC POST (subscribe + PDF) -->
              <button class="btn-sub" type="button" disabled>
                Souscrire
              </button>
              <button class="btn-pdf" type="button" disabled>
                PDF
              </button>
            </div>
          </section>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</main>

<!-- JS optionnel (wallet-balance etc.) -->
<script src="/template/js/idfit_app.js"></script>
</body>
</html>
