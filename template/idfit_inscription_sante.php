<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>IdFit — Inscription Étape 2</title>
    <link rel="stylesheet" href="css/idfit_inscription_sante.css">
    <link rel="stylesheet" href="css/inline.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    
    <script src="js/idfit_app.js"></script>
    <script>
      // Gestionnaire pour la sélection visuelle des objectifs
      document.addEventListener('DOMContentLoaded', () => {
        const objItems = document.querySelectorAll('.obj-item');
        objItems.forEach(item => {
          item.addEventListener('click', () => {
            objItems.forEach(i => i.classList.remove('on'));
            item.classList.add('on');
            // Optionnel : on peut recalculer la date cible si l'objectif change
            if(typeof calculateIMC === 'function') calculateIMC();
          });
        });

        // Calcul initial au chargement
        if(typeof calculateIMC === 'function') calculateIMC();
      });

      function allerRetour() {
        window.location.href = 'idfit_inscription_identite.php';
      }
    </script>
</head>
<body>

<div class="wrap">
  <div class="prog-header">
    <div class="prog-logo">IdFit</div>
    <div class="prog-steps">
      <div class="pstep">
        <div class="pstep-num done"><i class="ti ti-check"></i></div>
        <div class="pstep-label done">Identité</div>
      </div>
      <div class="pstep-line done"></div>
      <div class="pstep">
        <div class="pstep-num active">2</div>
        <div class="pstep-label active">Santé</div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-title">Vos informations de santé</div>
    <div class="card-sub">Étape 2 sur 2 — Ces données nous permettent de personnaliser votre programme</div>

    <div class="layout">
      <div class="form-col">
        <div class="u-style-33">
          <div class="field u-style-34">
            <div class="flabel"><i class="ti ti-ruler-measure"></i> Taille</div>
            <div class="inp-wrap">
              <input class="inp" id="taille" type="number" value="175" placeholder="cm">
              <span class="unit">cm</span>
            </div>
          </div>
          <div class="field u-style-34">
            <div class="flabel"><i class="ti ti-weight"></i> Poids actuel</div>
            <div class="inp-wrap">
              <input class="inp" id="poids" type="number" value="88" placeholder="kg">
              <span class="unit">kg</span>
            </div>
          </div>
          <div class="field u-style-34">
            <div class="flabel"><i class="ti ti-cake"></i> Âge</div>
            <div class="inp-wrap">
              <input class="inp" id="age" type="number" value="22" placeholder="ans">
              <span class="unit">ans</span>
            </div>
          </div>
        </div>

        <div class="field">
          <div class="flabel"><i class="ti ti-target"></i> Mon objectif principal</div>
          <div class="obj-list">
            <div class="obj-item" data-objective="increase">
              <div class="obj-radio"></div>
              <div class="obj-ico u-style-29"><i class="ti ti-trending-up"></i></div>
              <div>
                <div class="obj-name">Augmenter mon poids</div>
                <div class="obj-desc">Prise de masse musculaire</div>
              </div>
            </div>
            
            <div class="obj-item on" data-objective="reduce">
              <div class="obj-radio"></div>
              <div class="obj-ico u-style-25"><i class="ti ti-trending-down"></i></div>
              <div>
                <div class="obj-name">Réduire mon poids</div>
                <div class="obj-desc">Perte de poids durable</div>
              </div>
            </div>
            
            <div class="obj-item" data-objective="ideal">
              <div class="obj-radio"></div>
              <div class="obj-ico u-style-16"><i class="ti ti-focus"></i></div>
              <div>
                <div class="obj-name">Maintenir mon poids</div>
                <div class="obj-desc">Équilibre et santé globale</div>
              </div>
            </div>
          </div>
        </div>

        <div class="btn-row">
          <button class="btn-sec" onclick="allerRetour()">← Retour</button>
          <button class="btn-main" data-action="registerUser">
            Créer mon compte <i class="ti ti-arrow-right"></i>
          </button>
        </div>
      </div>

      <div class="imc-col">
        <div class="imc-box">
          <div class="imc-val" id="imc-val">--</div>
          <div class="imc-label">Votre IMC actuel</div>
          <div class="imc-bar"><div class="imc-needle" id="imc-needle"></div></div>
          <div class="imc-zones">
            <span>Maigre</span><span>Normal</span><span>Surpoids</span><span>Obèse</span>
          </div>
          <div class="imc-status" id="imc-status">Analyse en cours...</div>
        </div>
        
        <div class="ideal-box">
          <div class="ideal-label">Poids idéal estimé</div>
          <div class="ideal-val" id="ideal-val">-- kg</div>
          <div class="ideal-sub" id="ideal-diff">--</div>
          <div class="ideal-sub" id="target-date">Atteinte estimée : --</div>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>