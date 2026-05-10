<meta charset="UTF-8">
<link rel="stylesheet" href="css/idfit_admin.css">
  <link rel="stylesheet" href="css/inline.css">
<script src="js/idfit_app.js"></script>


<div class="layout">
  <div class="sidebar">
    <div class="sb-logo">IdFit <span class="sb-tag">ADMIN</span></div>
    <div class="sb-section">Tableau de bord</div>
    <div class="sb-item on"><i class="ti ti-dashboard" aria-hidden="true"></i> Statistiques</div>
    <div class="sb-section">Gestion</div>
    <div class="sb-item"><i class="ti ti-salad" aria-hidden="true"></i> Régimes</div>
    <div class="sb-item"><i class="ti ti-run" aria-hidden="true"></i> Sports</div>
    <div class="sb-item"><i class="ti ti-users" aria-hidden="true"></i> Utilisateurs</div>
    <div class="sb-item"><i class="ti ti-ticket" aria-hidden="true"></i> Codes</div>
    <div class="sb-section">Configuration</div>
    <div class="sb-item"><i class="ti ti-settings" aria-hidden="true"></i> Paramètres</div>
    <div class="sb-bottom">Admin · IdFit v1.0</div>
  </div>

  <div class="main">
    <div class="topbar">
      <div><div class="page-title">Tableau de bord Admin</div><div class="page-sub">Vue d'ensemble du système</div></div>
    </div>

    <div class="metrics">
      <div class="met">
        <div class="met-label"><i class="ti ti-users u-style-1" aria-hidden="true"></i> Utilisateurs</div>
        <div class="met-val">5</div>
        <div class="met-delta u-style-2">+2 ce mois</div>
      </div>
      <div class="met">
        <div class="met-label"><i class="ti ti-star u-style-1" aria-hidden="true"></i> Membres Gold</div>
        <div class="met-val u-style-3">3</div>
        <div class="met-delta u-style-4">60% des users</div>
      </div>
      <div class="met">
        <div class="met-label"><i class="ti ti-coin u-style-1" aria-hidden="true"></i> Revenus totaux</div>
        <div class="met-val u-style-5">335 000</div>
        <div class="met-delta u-style-4">Ar ce mois</div>
      </div>
      <div class="met">
        <div class="met-label"><i class="ti ti-ticket u-style-1" aria-hidden="true"></i> Codes utilisés</div>
        <div class="met-val">9 <span class="u-style-6">/ 15</span></div>
        <div class="met-delta u-style-4">6 disponibles</div>
      </div>
    </div>

    <div class="grid2">
      <div class="card">
        <div class="card-head">
          <div class="card-title"><i class="ti ti-chart-pie u-style-5" aria-hidden="true"></i> Répartition par régime</div>
        </div>
        <div class="chart-wrap"><canvas id="regimeChart"></canvas></div>
      </div>
      <div class="card">
        <div class="card-head">
          <div class="card-title"><i class="ti ti-chart-bar u-style-3" aria-hidden="true"></i> Revenus mensuels</div>
        </div>
        <div class="chart-wrap"><canvas id="revenueChart"></canvas></div>
      </div>
    </div>

    <div class="grid2">
      <div class="card">
        <div class="card-head">
          <div class="card-title"><i class="ti ti-salad u-style-5" aria-hidden="true"></i> Gestion des régimes</div>
          <button class="btn-add"><i class="ti ti-plus" aria-hidden="true"></i> Ajouter</button>
        </div>
        <table class="table">
          <tr><th>Nom</th><th>Objectif</th><th>Prix/mois</th><th>Actions</th></tr>
          <tr><td>Méditerranéen</td><td><span class="badge bd-green">Réduire</span></td><td>53 000 Ar</td><td><div class="action-btns"><button class="btn-edit"><i class="ti ti-edit" aria-hidden="true"></i></button><button class="btn-del"><i class="ti ti-trash" aria-hidden="true"></i></button></div></td></tr>
          <tr><td>Végétarien</td><td><span class="badge bd-green">Réduire</span></td><td>42 000 Ar</td><td><div class="action-btns"><button class="btn-edit"><i class="ti ti-edit" aria-hidden="true"></i></button><button class="btn-del"><i class="ti ti-trash" aria-hidden="true"></i></button></div></td></tr>
          <tr><td>Hyperprotéiné</td><td><span class="badge bd-amber">Augmenter</span></td><td>65 000 Ar</td><td><div class="action-btns"><button class="btn-edit"><i class="ti ti-edit" aria-hidden="true"></i></button><button class="btn-del"><i class="ti ti-trash" aria-hidden="true"></i></button></div></td></tr>
          <tr><td>Équilibré IMC</td><td><span class="badge bd-purple">IMC idéal</span></td><td>58 000 Ar</td><td><div class="action-btns"><button class="btn-edit"><i class="ti ti-edit" aria-hidden="true"></i></button><button class="btn-del"><i class="ti ti-trash" aria-hidden="true"></i></button></div></td></tr>
          <tr><td>Cétogène</td><td><span class="badge bd-green">Réduire</span></td><td>70 000 Ar</td><td><div class="action-btns"><button class="btn-edit"><i class="ti ti-edit" aria-hidden="true"></i></button><button class="btn-del"><i class="ti ti-trash" aria-hidden="true"></i></button></div></td></tr>
        </table>
      </div>

      <div class="card">
        <div class="card-head">
          <div class="card-title"><i class="ti ti-ticket u-style-3" aria-hidden="true"></i> Gestion des codes</div>
          <button class="btn-add"><i class="ti ti-plus" aria-hidden="true"></i> Générer</button>
        </div>
        <table class="table">
          <tr><th>Code</th><th>Valeur</th><th>Statut</th><th>Action</th></tr>
          <tr><td class="u-style-7">IDFT-4521</td><td>50 000 Ar</td><td><span class="badge bd-used">Utilisé</span></td><td>—</td></tr>
          <tr><td class="u-style-7">IDFT-7823</td><td>100 000 Ar</td><td><span class="badge bd-used">Utilisé</span></td><td>—</td></tr>
          <tr><td class="u-style-7">IDFT-1190</td><td>50 000 Ar</td><td><span class="badge bd-green">Disponible</span></td><td><button class="btn-val"><i class="ti ti-check" aria-hidden="true"></i> Valider</button></td></tr>
          <tr><td class="u-style-7">IDFT-3344</td><td>20 000 Ar</td><td><span class="badge bd-green">Disponible</span></td><td><button class="btn-val"><i class="ti ti-check" aria-hidden="true"></i> Valider</button></td></tr>
          <tr><td class="u-style-7">IDFT-9900</td><td>75 000 Ar</td><td><span class="badge bd-red">Expiré</span></td><td>—</td></tr>
        </table>
      </div>
    </div>

    <div class="card">
      <div class="card-head"><div class="card-title"><i class="ti ti-settings u-style-5" aria-hidden="true"></i> Paramètres système</div></div>
      <div class="params-grid">
        <div class="param-item"><div class="param-label">Prix Gold</div><div class="param-val">20 000 Ar</div><div class="param-edit"><i class="ti ti-edit u-style-8" aria-hidden="true"></i> Modifier</div></div>
        <div class="param-item"><div class="param-label">Remise Gold</div><div class="param-val">15%</div><div class="param-edit"><i class="ti ti-edit u-style-8" aria-hidden="true"></i> Modifier</div></div>
        <div class="param-item"><div class="param-label">IMC Normal min</div><div class="param-val">18.5</div><div class="param-edit"><i class="ti ti-edit u-style-8" aria-hidden="true"></i> Modifier</div></div>
        <div class="param-item"><div class="param-label">IMC Normal max</div><div class="param-val">24.9</div><div class="param-edit"><i class="ti ti-edit u-style-8" aria-hidden="true"></i> Modifier</div></div>
        <div class="param-item"><div class="param-label">IMC Surpoids</div><div class="param-val">25–30</div><div class="param-edit"><i class="ti ti-edit u-style-8" aria-hidden="true"></i> Modifier</div></div>
        <div class="param-item"><div class="param-label">IMC Obésité</div><div class="param-val">&gt; 30</div><div class="param-edit"><i class="ti ti-edit u-style-8" aria-hidden="true"></i> Modifier</div></div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
<script src="js/idfit_admin.js"></script>



