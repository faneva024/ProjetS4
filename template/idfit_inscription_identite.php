<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>IdFit — Inscription Étape 1</title>
    <link rel="stylesheet" href="css/idfit_inscription_identite.css">
    <link rel="stylesheet" href="css/inline.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    
    <script src="js/idfit_app.js"></script>
    <script>
      function preparerEtape1() {
        // Validation simple avant envoi
        const prenom = document.getElementById('prenom').value;
        const nom = document.getElementById('nom').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const confirm = document.getElementById('confirm-password').value;

        if (!prenom || !nom || !email || !password) {
            alert("Veuillez remplir tous les champs.");
            return;
        }

        if (password !== confirm) {
            alert("Les mots de passe ne correspondent pas.");
            return;
        }

        // On rassemble les données
        const identite = {
            prenom: prenom,
            nom: nom,
            email: email,
            password: password,
            // Récupère la première lettre du bouton qui a la classe 'on' (H, F ou A)
            genre: document.querySelector('.genre-btn.on')?.innerText.trim().charAt(0) || 'H'
        };

        // On envoie l'objet à la fonction de idfit_app.js pour stockage localStorage
        saveTempUser(identite);
      }

      // Gestionnaire pour changer la classe 'on' des boutons de genre
      document.addEventListener('DOMContentLoaded', () => {
        const genreBtns = document.querySelectorAll('.genre-btn');
        genreBtns.forEach(btn => {
          btn.addEventListener('click', () => {
            genreBtns.forEach(b => b.classList.remove('on'));
            btn.classList.add('on');
          });
        });
      });
    </script>
</head>
<body>

<div class="wrap">
  <div class="prog-header">
    <div class="prog-logo">IdFit</div>
    <div class="prog-steps">
      <div class="pstep">
        <div class="pstep-num active">1</div>
        <div class="pstep-label active">Identité</div>
      </div>
      <div class="pstep-line"></div>
      <div class="pstep">
        <div class="pstep-num idle">2</div>
        <div class="pstep-label idle">Santé</div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-title">Créer votre compte</div>
    <div class="card-sub">Étape 1 sur 2 — Informations personnelles</div>

    <div class="hint-box">
      <i class="ti ti-shield-check hint-ico" aria-hidden="true"></i>
      <div class="hint-txt">Vos données sont protégées et ne seront jamais partagées avec des tiers.</div>
    </div>

    <div class="row2">
      <div class="field">
        <div class="flabel"><i class="ti ti-user" aria-hidden="true"></i> Prénom</div>
        <input id="prenom" class="inp" placeholder="Ex: Finaritra">
      </div>
      <div class="field">
        <div class="flabel"><i class="ti ti-user" aria-hidden="true"></i> Nom</div>
        <input id="nom" class="inp" placeholder="Ex: Rakoto">
      </div>
    </div>

    <div class="field">
      <div class="flabel"><i class="ti ti-users" aria-hidden="true"></i> Genre</div>
      <div class="genre-row">
        <button type="button" class="genre-btn on"><i class="ti ti-gender-male" aria-hidden="true"></i> Homme</button>
        <button type="button" class="genre-btn"><i class="ti ti-gender-female" aria-hidden="true"></i> Femme</button>
        <button type="button" class="genre-btn"><i class="ti ti-gender-bigender" aria-hidden="true"></i> Autre</button>
      </div>
    </div>

    <div class="field">
      <div class="flabel"><i class="ti ti-mail" aria-hidden="true"></i> Email</div>
      <input id="email" class="inp" type="email" placeholder="votre@email.com">
      <div id="email-status" class="err-msg" style="display:none;">
        <i class="ti ti-alert-circle" aria-hidden="true"></i> Adresse email invalide
      </div>
    </div>

    <div class="row2">
      <div class="field">
        <div class="flabel"><i class="ti ti-lock" aria-hidden="true"></i> Mot de passe</div>
        <input id="password" class="inp" type="password" placeholder="••••••••">
        <div class="pw-bar">
          <div class="ps"></div><div class="ps"></div><div class="ps"></div><div class="ps"></div>
        </div>
      </div>
      <div class="field">
        <div class="flabel"><i class="ti ti-lock-check" aria-hidden="true"></i> Confirmer mot de passe</div>
        <input id="confirm-password" class="inp" type="password" placeholder="••••••••">
      </div>
    </div>

    <div class="btn-row">
      <a href="idfit_connexion.php" class="btn-sec">Annuler</a>
      <button class="btn-main" onclick="preparerEtape1()">
        Continuer <i class="ti ti-arrow-right" aria-hidden="true"></i>
      </button>
    </div>
  </div>
</div>

</body>
</html>