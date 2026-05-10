/**
 * IdFit app bootstrap
 * Objectif : brancher les actions UI vers le backend CodeIgniter.
 */

(function () {
  const API_PROFILE = '/api/profile';
  const API_LOGIN = '/api/login';
  const API_REGISTER = '/api/register';

  const API_WEIGHT_ADD = '/api/weight';
  const API_WALLET_RECHARGE = '/wallet/recharge';
  const API_GOLD_UPGRADE = '/gold/upgrade';

  const API_TEMP_USER_KEY = 'idfit_temp_user_v1';

  const FORM_URLENCODED_HEADERS = {
    'Content-Type': 'application/x-www-form-urlencoded',
    Accept: 'application/json',
  };

  function postForm(url, formObj) {
    const body = Object.entries(formObj)
      .map(([k, v]) => encodeURIComponent(k) + '=' + encodeURIComponent(v ?? ''))
      .join('&');

    return fetch(url, {
      method: 'POST',
      headers: FORM_URLENCODED_HEADERS,
      credentials: 'same-origin',
      body,
    });
  }

  function readInputValue(id) {
    const el = document.getElementById(id);
    return el ? String(el.value ?? '') : '';
  }

  function normalizeEmail(email) {
    return String(email || '').trim().toLowerCase();
  }

  function setTextById(id, text) {
    const el = document.getElementById(id);
    if (el) el.textContent = String(text ?? '');
  }

  function setWalletBalanceUI(balanceAr) {
    const value = Number(balanceAr || 0).toLocaleString('fr-FR');
    document.querySelectorAll('[data-wallet-balance]').forEach((n) => {
      n.textContent = value + ' Ar';
    });
    const walletBalanceNode = document.getElementById('wallet-balance');
    if (walletBalanceNode) walletBalanceNode.textContent = value;
  }

  function setGoldStatusUI(isGold) {
    const goldStatus = document.querySelector('.w-status');
    if (!goldStatus) return;

    const icon = isGold
      ? '<i class="ti ti-circle-check u-style-1" aria-hidden="true"></i>'
      : '<i class="ti ti-circle-x u-style-1" aria-hidden="true"></i>';

    goldStatus.innerHTML = icon + (isGold ? ' Compte Gold actif' : ' Compte Gold inactif');
  }

  async function syncProfile() {
    try {
      const res = await fetch(API_PROFILE, {
        headers: { Accept: 'application/json' },
        credentials: 'same-origin',
      });

      if (!res.ok) return false;

      const payload = await res.json();
      const user = payload && payload.data ? payload.data.user : payload.user;
      if (!user) return false;

      const prenom = user.prenom || '';
      const walletBalance = user.wallet_balance ?? user.wallet ?? 0;
      const isGold = Boolean(Number(user.is_gold ?? user.gold ?? 0));

      // Dashboard page
      if (document.querySelector('.page-title') && prenom) {
        document.querySelector('.page-title').textContent = 'Bonjour, ' + prenom + ' 👋';
      }

      // IMC (si présents sur la page)
      if (document.getElementById('imc-val') && user.poids != null) {
        setTextById('imc-val', Number(user.poids).toFixed(1));
      }

      setWalletBalanceUI(walletBalance);
      setGoldStatusUI(isGold);

      return true;
    } catch {
      return false;
    }
  }

  function setMessage(target, text, tone) {
    const el = typeof target === 'string' ? document.getElementById(target) : target;
    if (!el) return;
    el.textContent = String(text ?? '');
    el.style.color = tone === 'ok' ? '#0F6E56' : '#791F1F';
    el.style.display = 'block';
  }

  async function authenticate() {
    const email = normalizeEmail(readInputValue('login-email'));
    const password = readInputValue('login-password');
    const messageEl = document.getElementById('login-message');

    if (!email) return setMessage(messageEl, 'Email requis', 'bad');
    if (!password) return setMessage(messageEl, 'Mot de passe requis', 'bad');

    try {
      const res = await postForm(API_LOGIN, { email, password });
      const payload = await res.json().catch(() => ({}));

      if (!res.ok || !payload || !payload.success) {
        return setMessage(messageEl, payload.message || 'Identifiants invalides', 'bad');
      }

      await syncProfile();

      const role = (payload.data && payload.data.user && payload.data.user.role) || payload.role || 'user';
      window.location.href = role === 'admin' ? 'idfit_admin.php' : 'idfit_dashboard_user.php';
    } catch {
      setMessage(messageEl, 'Erreur connexion', 'bad');
    }
  }

  function saveTempUser() {
    const nom = readInputValue('identity-last-name');
    const prenom = readInputValue('identity-first-name');
    const email = normalizeEmail(readInputValue('identity-email'));
    const password = readInputValue('identity-password');

    // Genre sélectionné : sur le template il y a .genre-btn.on
    const genreEl = document.querySelector('.genre-btn.on');
    const genre = genreEl ? genreEl.textContent.toLowerCase() : '';

    // map text -> H/F
    let genreValue = 'H';
    if (genre.includes('femme') || genre.includes('female')) genreValue = 'F';
    if (genre.includes('homme') || genre.includes('male')) genreValue = 'H';

    // validation minimale (le template affiche déjà des erreurs d'UI)
    if (!nom || !prenom || !email || !password) {
      const msg = document.getElementById('identity-email-status');
      setMessage(msg || 'identity-email-status', 'Champs requis manquants', 'bad');
      return false;
    }

    const tempUser = {
      nom,
      prenom,
      email,
      password,
      genre: genreValue,
    };

    try {
      window.sessionStorage.setItem(API_TEMP_USER_KEY, JSON.stringify(tempUser));
    } catch {
      // fallback localStorage si sessionStorage indisponible
      window.localStorage.setItem(API_TEMP_USER_KEY, JSON.stringify(tempUser));
    }

    // Va vers la page santé
    window.location.href = 'idfit_inscription_sante.php';
    return true;
  }

  function getTempUser() {
    const raw =
      window.sessionStorage.getItem(API_TEMP_USER_KEY) ||
      window.localStorage.getItem(API_TEMP_USER_KEY);

    if (!raw) return null;
    try {
      return JSON.parse(raw);
    } catch {
      return null;
    }
  }

  async function registerUser() {
    // sur idfit_inscription_sante.html : identité vient de saveTempUser()
    const tempUser = getTempUser();
    if (!tempUser) {
      alert('Session inscription expirée. Recommencez l’étape Identité.');
      window.location.href = 'idfit_inscription_identite.php';
      return;
    }

    const taille = readInputValue('taille');
    const poids = readInputValue('poids');

    if (!taille || !poids) {
      alert('Taille et poids requis.');
      return;
    }

    try {
      // objectif sélectionné
      const objectiveEl = document.querySelector('.obj-item.on');
      const objective = objectiveEl ? objectiveEl.dataset.objective : 'reduce';
      // NB: l’API register backend ne prend pas objective (routes/AuthController::register)
      // donc on ne l’envoie pas pour rester conforme.

      const res = await postForm(API_REGISTER, {
        nom: tempUser.nom,
        prenom: tempUser.prenom,
        genre: tempUser.genre,
        email: tempUser.email,
        password: tempUser.password,
        taille,
        poids,
      });

      const payload = await res.json().catch(() => ({}));

      if (!res.ok || !payload || !payload.success) {
        alert(payload.message || 'Erreur inscription');
        return;
      }

      // Une fois inscrit, on n'est pas automatiquement connecté (pas de session après /api/register).
      // Donc on renvoie vers la page connexion.
      window.location.href = 'idfit_connexion.php';
    } catch {
      alert('Erreur réseau inscription');
    }
  }

  async function updateWeightHistory() {
    const weightInput = document.getElementById('weight-value');
    const dateInput = document.getElementById('weight-date');

    if (!weightInput || !dateInput) return;

    const poids = parseFloat(weightInput.value);
    const date_mesure = dateInput.value || new Date().toISOString().slice(0, 10);

    if (!Number.isFinite(poids) || poids <= 0) {
      alert('Poids invalide');
      return;
    }

    const noteInput = document.getElementById('weight-note');
    const note = noteInput ? String(noteInput.value || '') : '';
    // Backend attend seulement poids + date_mesure (pas note), on l’ignore si non géré.

    try {
      const res = await postForm(API_WEIGHT_ADD, { poids, date_mesure });
      const payload = await res.json().catch(() => ({}));

      if (!res.ok || !payload || payload.success !== true) {
        alert(payload.message || 'Erreur ajout poids');
        return;
      }

      await syncProfile();
      alert('Poids enregistre');
    } catch {
      alert('Erreur réseau');
    }
  }

  async function creditWallet() {
    const codeInput = document.getElementById('wallet-code');
    if (!codeInput) return;

    const code = String(codeInput.value || '').trim();
    if (!code) {
      alert('Code requis');
      return;
    }

    try {
      const res = await fetch(API_WALLET_RECHARGE, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
          Accept: 'application/json',
        },
        credentials: 'same-origin',
        body: 'code=' + encodeURIComponent(code),
      });
      const payload = await res.json().catch(() => ({}));

      if (!res.ok || !payload.success) {
        alert(payload.message || 'Code invalide');
        return;
      }

      setWalletBalanceUI(payload.solde);
      alert('Compte credite');
    } catch {
      alert('Erreur réseau');
    }
  }

  async function upgradeToGold() {
    try {
      const res = await fetch(API_GOLD_UPGRADE, {
        method: 'POST',
        headers: { Accept: 'application/json' },
        credentials: 'same-origin',
      });
      const payload = await res.json().catch(() => ({}));

      if (!res.ok || !payload.success) {
        alert(payload.message || 'Erreur activation gold');
        return;
      }

      setWalletBalanceUI(payload.solde);
      setGoldStatusUI(true);
      alert('Gold actif');
    } catch {
      alert('Erreur réseau');
    }
  }

  function bindDeclarativeActions() {
    document.addEventListener('click', (event) => {
      const actionEl = event.target.closest('[data-action]');
      if (!actionEl) return;

      const actionName = actionEl.getAttribute('data-action');
      if (!actionName) return;

      const map = {
        authenticate,
        saveTempUser,
        registerUser,
        updateWeightHistory,
        creditWallet,
        upgradeToGold,
      };

      const fn = map[actionName];
      if (typeof fn === 'function') {
        event.preventDefault();
        fn();
      }
    });
  }

  function initBootstrap() {
    bindDeclarativeActions();

    // Sync au démarrage si une page utilisateur est chargée
    const hasUserUI = document.querySelector('.page-title') || document.getElementById('wallet-balance') || document.getElementById('weightChart');
    if (hasUserUI) syncProfile();
  }

  document.addEventListener('DOMContentLoaded', initBootstrap);
})();
