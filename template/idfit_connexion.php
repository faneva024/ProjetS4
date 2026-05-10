<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>IdFit — Connexion</title>
    <link rel="stylesheet" href="css/idfit_inscription_identite.css"> <!-- Réutilisation du style existant -->
    <link rel="stylesheet" href="css/inline.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    
    <script src="js/idfit_app.js"></script>
</head>
<body>

<div class="wrap">
  <div class="prog-header">
    <div class="prog-logo">IdFit</div>
  </div>

  <div class="card">
    <div class="card-title">Bon retour parmi nous</div>
    <div class="card-sub">Connectez-vous pour accéder à votre programme personnalisé</div>

    <div class="field">
      <div class="flabel"><i class="ti ti-mail" aria-hidden="true"></i> Email</div>
      <input id="login-email" class="inp" type="email" placeholder="votre@email.com">
    </div>

    <div class="field">
      <div class="flabel"><i class="ti ti-lock" aria-hidden="true"></i> Mot de passe</div>
      <input id="login-password" class="inp" type="password" placeholder="••••••••">
    </div>

    <div id="login-message" class="err-msg" style="display:none; margin-bottom: 20px;">
      <i class="ti ti-alert-circle" aria-hidden="true"></i>
    </div>

    <div class="btn-row">
      <a href="vitrine.php" class="btn-sec">Accueil</a>
      <button class="btn-main" data-action="authenticate">
        Se connecter <i class="ti ti-login" aria-hidden="true"></i>
      </button>
    </div>

    <div style="margin-top: 30px; text-align: center; border-top: 1px solid #eee; padding-top: 20px;">
        <p style="color: #666; font-size: 0.9rem;">Pas encore de compte ?</p>
        <a href="idfit_inscription_identite.php" style="color: #7c3aed; font-weight: 600; text-decoration: none;">Créer un compte maintenant</a>
    </div>
  </div>
</div>

<style>
    /* Petit ajustement pour le message d'erreur spécifique à la connexion */
    .err-msg {
        padding: 10px;
        border-radius: 8px;
        background: #fff5f5;
        font-size: 0.9rem;
        border: 1px solid #feb2b2;
    }
</style>

</body>
</html>