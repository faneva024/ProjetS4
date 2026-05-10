(function () {
  // Constantes utiles
  const SESSION_KEY = 'idfit_session';

  /**
   * INITIALISATION DE L'APPLICATION
   * Détecte la page actuelle et lance les scripts nécessaires
   */
  function initApp() {
    console.log("IdFit : Initialisation du frontend...");

    // Initialisation des boutons d'action globaux
    document.addEventListener('click', function(e) {
      const target = e.target.closest('[data-action]');
      if (!target) return;

      const action = target.getAttribute('data-action');
      if (action === 'registerUser') {
        e.preventDefault();
        registerUser();
      }
      if (action === 'authenticate' || action === 'login') {
        e.preventDefault();
        authenticateUser();
      }
    });

    // Détection des composants spécifiques aux pages
    if (document.getElementById('taille') || document.getElementById('poids')) {
      // On attache le calcul IMC automatique
      const inputs = [document.getElementById('taille'), document.getElementById('poids')];
      inputs.forEach(inp => { if(inp) inp.addEventListener('input', calculateIMC); });
      calculateIMC(); // Calcul initial
    }

    if (document.getElementById('weightChart')) {
      // Ici, on appellera une fonction fetch pour remplir le graphique
      console.log("Dashboard détecté : En attente des données API...");
    }
  }

  /**
   * AUTHENTIFICATION : CONNEXION UTILISATEUR
   */
  async function authenticateUser() {
    const email = document.getElementById('login-email')?.value;
    const password = document.getElementById('login-password')?.value;
    const messageEl = document.getElementById('login-message');

    if (!email || !password) {
      alert("Veuillez saisir votre email et votre mot de passe.");
      return;
    }

    const formData = new FormData();
    formData.append('email', email);
    formData.append('password', password);

    try {
      // On utilise l'API de login définie dans tes routes (/api/login)
      const response = await fetch('/api/login', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      });

      const result = await response.json();

      if (result.success || result.status === 'success') {
        // Redirection vers le dashboard après succès
        window.location.href = result.redirect || 'idfit_dashboard_user.php';
      } else {
        alert(result.message || "Identifiants incorrects.");
      }
    } catch (error) {
      console.error("Erreur de connexion :", error);
      alert("Impossible de contacter le serveur. Vérifiez que le backend est lancé.");
    }
  }

  /**
   * CALCUL DE L'IMC ET INTERFACE (UI)
   */
  function calculateIMC() {
    const heightInput = document.getElementById('taille');
    const weightInput = document.getElementById('poids');
    const imcVal = document.getElementById('imc-val');
    const imcStatus = document.getElementById('imc-status');
    const imcNeedle = document.getElementById('imc-needle');

    if (!heightInput || !weightInput || !imcVal) return;

    const h = parseFloat(heightInput.value) / 100;
    const w = parseFloat(weightInput.value);

    if (h > 0 && w > 0) {
      const imc = (w / (h * h)).toFixed(1);
      imcVal.innerText = imc;

      // Mise à jour de la barre visuelle (Ajustement selon ton CSS)
      let percent = (imc - 10) * 100 / 30; 
      percent = Math.min(Math.max(percent, 0), 100);
      if (imcNeedle) imcNeedle.style.left = `${percent}%`;

      // État de santé
      let status = "";
      if (imc < 18.5) status = "Insuffisance pondérale";
      else if (imc < 25) status = "Poids normal";
      else if (imc < 30) status = "Surpoids";
      else status = "Obésité";
      
      if (imcStatus) imcStatus.innerText = status;
      
      calculateTargetDate(w, h);
    }
  }

  /**
   * ESTIMATION DE LA DATE CIBLE
   */
  function calculateTargetDate(currentWeight, height) {
    const targetDateEl = document.getElementById('target-date');
    const idealValEl = document.getElementById('ideal-val');
    if (!targetDateEl) return;

    const idealWeight = (22 * height * height).toFixed(1);
    if (idealValEl) idealValEl.innerText = `${idealWeight} kg`;

    const diff = currentWeight - idealWeight;
    const weeks = Math.abs(diff) / 0.5; // On estime 500g par semaine
    const targetDate = new Date();
    targetDate.setDate(targetDate.getDate() + (weeks * 7));

    targetDateEl.innerText = `Atteinte estimée : ${targetDate.toLocaleDateString()}`;
  }

  /**
   * INSCRIPTION : ENVOI DES DONNÉES AU SERVEUR (PHASE 2)
   */
  async function registerUser() {
    // 1. Récupérer les données de l'étape 1 stockées en localStorage
    const tempUser = JSON.parse(localStorage.getItem('idfit_temp_identity'));
    
    if (!tempUser) {
      alert("Erreur : Données d'identité manquantes. Veuillez recommencer l'étape 1.");
      window.location.href = 'idfit_inscription_identite.php';
      return;
    }

    // 2. Récupérer les données de l'étape 2 (Santé)
    const height = document.getElementById('taille').value;
    const weight = document.getElementById('poids').value;
    const objectiveEl = document.querySelector('.obj-item.on');
    const objective = objectiveEl ? objectiveEl.getAttribute('data-objective') : 'ideal';

    // 3. Préparation de l'envoi
    const formData = new FormData();
    formData.append('nom', tempUser.nom);
    formData.append('prenom', tempUser.prenom);
    formData.append('genre', tempUser.genre);
    formData.append('email', tempUser.email);
    formData.append('password', tempUser.password);
    formData.append('taille', height);
    formData.append('poids', weight);
    formData.append('objectif', objective);

    try {
      const response = await fetch('/auth/registerFull', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      });

      const result = await response.json();

      if (result.status === 'success') {
        localStorage.removeItem('idfit_temp_identity'); // Nettoyage
        window.location.href = result.redirect;
      } else {
        const errorMsg = result.errors ? Object.values(result.errors).join("\n") : "Erreur inconnue";
        alert("Erreur lors de l'inscription :\n" + errorMsg);
      }
    } catch (error) {
      console.error("Erreur de connexion :", error);
      alert("Erreur de communication avec le serveur. Vérifiez que le backend est lancé sur le bon port.");
    }
  }

  /**
   * ÉTAPE 1 : SAUVEGARDE TEMPORAIRE (FRONTEND)
   */
  window.saveTempUser = function(data) {
    localStorage.setItem('idfit_temp_identity', JSON.stringify(data));
    window.location.href = 'idfit_inscription_sante.php';
  };

  // Lancement
  document.addEventListener('DOMContentLoaded', initApp);

})();