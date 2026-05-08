(function () {
  const DB_KEY = 'idfit_db';
  const SESSION_KEY = 'idfit_session';

  const DEFAULT_DB = {
    users: [
      {
        email: 'admin@idfit.local',
        password: 'Admin123!',
        role: 'admin',
        firstName: 'Admin',
        lastName: 'IdFit',
        gender: 'Autre',
        gold: false,
        wallet: 0,
        objective: 'ideal',
        height: 175,
        weight: 88,
      },
      {
        email: 'finaritra@gmail.com',
        password: 'Idfit2025@',
        role: 'user',
        firstName: 'Finaritra',
        lastName: 'Rakoto',
        gender: 'Homme',
        gold: true,
        wallet: 85000,
        objective: 'reduce',
        height: 175,
        weight: 85.2,
      },
    ],
    tempUser: null,
    codes: [
      { code: 'IDFT-4521', amount: 50000, used: true },
      { code: 'IDFT-7823', amount: 100000, used: true },
      { code: 'IDFT-1190', amount: 50000, used: false },
      { code: 'IDFT-3344', amount: 20000, used: false },
      { code: 'IDFT-9900', amount: 75000, used: false },
    ],
    regimes: [
      { name: 'Mediterraneen', objective: 'reduce', price: 53000, goldPrice: 45000, macros: { viande: 30, poisson: 40, volaille: 30 }, sports: ['Cardio 3x/sem', 'Natation 2x/sem'] },
      { name: 'Vegetarien', objective: 'reduce', price: 42000, goldPrice: 35700, macros: { viande: 0, poisson: 20, volaille: 0 }, sports: ['Velo 3x/sem', 'Marche 5x/sem'] },
      { name: 'Hyperproteine', objective: 'increase', price: 65000, goldPrice: 55250, macros: { viande: 50, poisson: 20, volaille: 30 }, sports: ['Muscu 4x/sem'] },
      { name: 'Equilibre IMC', objective: 'ideal', price: 58000, goldPrice: 49300, macros: { viande: 35, poisson: 35, volaille: 30 }, sports: ['Yoga 3x/sem', 'Jogging 2x/sem'] },
      { name: 'Cetogene', objective: 'reduce', price: 70000, goldPrice: 59500, macros: { viande: 45, poisson: 35, volaille: 20 }, sports: ['Cardio 4x/sem'] },
    ],
    sports: [
      { name: 'Cardio', objective: 'reduce', regime: 'Mediterraneen' },
      { name: 'Natation', objective: 'reduce', regime: 'Mediterraneen' },
      { name: 'Musculation', objective: 'increase', regime: 'Hyperproteine' },
      { name: 'Yoga', objective: 'ideal', regime: 'Equilibre IMC' },
    ],
    systemConfig: {
      goldPrice: 20000,
      goldDiscount: 0.15,
      imcMin: 18.5,
      imcMax: 24.9,
      imcOver: 30,
    },
    weightHistory: {
      'finaritra@gmail.com': [
        { date: '2025-04-21', weight: 88 },
        { date: '2025-04-28', weight: 86.5 },
        { date: '2025-05-05', weight: 85.2 },
      ],
    },
    transactions: [
      { email: 'finaritra@gmail.com', type: 'regime', amount: 45000, label: 'Mediterraneen', date: '2025-05-01' },
      { email: 'finaritra@gmail.com', type: 'gold', amount: 20000, label: 'Gold activation', date: '2025-04-28' },
    ],
  };

  function clone(value) {
    return JSON.parse(JSON.stringify(value));
  }

  function readStorage(storage, key) {
    try {
      const raw = storage.getItem(key);
      return raw ? JSON.parse(raw) : null;
    } catch (error) {
      return null;
    }
  }

  function writeStorage(storage, key, value) {
    try {
      storage.setItem(key, JSON.stringify(value));
      return true;
    } catch (error) {
      return false;
    }
  }

  function ensureDb() {
    const localDb = readStorage(window.localStorage, DB_KEY);
    if (localDb) {
      return localDb;
    }
    const sessionDb = readStorage(window.sessionStorage, DB_KEY);
    if (sessionDb) {
      writeStorage(window.localStorage, DB_KEY, sessionDb);
      return sessionDb;
    }
    const db = clone(DEFAULT_DB);
    writeStorage(window.localStorage, DB_KEY, db);
    writeStorage(window.sessionStorage, DB_KEY, db);
    return db;
  }

  function saveDb(db) {
    writeStorage(window.localStorage, DB_KEY, db);
    writeStorage(window.sessionStorage, DB_KEY, db);
  }

  function normalizeEmail(email) {
    return String(email || '').trim().toLowerCase();
  }

  function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }

  function getSession() {
    return readStorage(window.sessionStorage, SESSION_KEY) || readStorage(window.localStorage, SESSION_KEY) || {};
  }

  function setSession(session) {
    writeStorage(window.sessionStorage, SESSION_KEY, session);
    writeStorage(window.localStorage, SESSION_KEY, session);
  }

  function getCurrentUser() {
    const db = ensureDb();
    const session = getSession();
    const email = normalizeEmail(session.email) || 'finaritra@gmail.com';
    return db.users.find((user) => normalizeEmail(user.email) === email) || db.users[1] || db.users[0] || null;
  }

  function setMessage(target, text, tone) {
    const element = typeof target === 'string' ? document.getElementById(target) : target;
    if (!element) {
      return;
    }
    element.textContent = text;
    element.style.color = tone === 'ok' ? '#0F6E56' : '#791F1F';
    element.style.display = 'block';
  }

  function updateButtonText(button, text) {
    if (button) {
      button.textContent = text;
    }
  }

  function getSelectedObjective() {
    const selected = document.querySelector('.obj-item.on[data-objective]');
    if (selected) {
      return selected.dataset.objective;
    }
    return 'reduce';
  }

  function getSelectedGender() {
    const selected = document.querySelector('.genre-btn.on');
    if (!selected) {
      return 'Autre';
    }
    return selected.textContent.replace(/\s+/g, ' ').trim();
  }

  function getSelectedObjectiveLabel(objective) {
    if (objective === 'increase') {
      return 'Augmenter';
    }
    if (objective === 'ideal') {
      return 'IMC ideal';
    }
    return 'Reduire';
  }

  function checkEmailUnique(email) {
    const normalizedEmail = normalizeEmail(email);
    const db = ensureDb();
    const exists = db.users.some((user) => normalizeEmail(user.email) === normalizedEmail);
    const status = document.getElementById('identity-email-status');
    if (!isValidEmail(normalizedEmail)) {
      setMessage(status, 'Adresse email invalide', 'bad');
      return false;
    }
    if (exists) {
      setMessage(status, 'Email deja utilise', 'bad');
      return false;
    }
    setMessage(status, 'Email disponible', 'ok');
    return true;
  }

  function saveTempUser() {
    const firstNameInput = document.getElementById('identity-first-name') || document.querySelector('.row2 .field:nth-child(1) input');
    const lastNameInput = document.getElementById('identity-last-name') || document.querySelector('.row2 .field:nth-child(2) input');
    const emailInput = document.getElementById('identity-email') || document.querySelector('.field input[type="email"]');
    const passwordInput = document.getElementById('identity-password') || document.querySelector('.row2 .field input[type="password"]');
    const confirmInput = document.getElementById('identity-confirm-password') || document.querySelectorAll('.row2 .field input[type="password"]')[1];

    const firstName = String(firstNameInput ? firstNameInput.value : '').trim();
    const lastName = String(lastNameInput ? lastNameInput.value : '').trim();
    const email = normalizeEmail(emailInput ? emailInput.value : '');
    const password = String(passwordInput ? passwordInput.value : '');
    const confirmPassword = String(confirmInput ? confirmInput.value : '');

    if (!firstName || !lastName) {
      setMessage('identity-email-status', 'Nom et prenom requis', 'bad');
      return false;
    }
    if (!checkEmailUnique(email)) {
      return false;
    }
    if (password.length < 6) {
      setMessage('identity-email-status', 'Mot de passe trop court', 'bad');
      return false;
    }
    if (password !== confirmPassword) {
      setMessage('identity-email-status', 'Les mots de passe ne correspondent pas', 'bad');
      return false;
    }

    const tempUser = {
      firstName,
      lastName,
      gender: getSelectedGender(),
      email,
      password,
      role: 'user',
      gold: false,
      objective: getSelectedObjective(),
    };

    const db = ensureDb();
    db.tempUser = tempUser;
    saveDb(db);
    setMessage('identity-email-status', 'Etape 1 enregistree. Passez a la sante.', 'ok');
    window.location.href = 'idfit_inscription_sante.html';
    return true;
  }

  function calculateTargetDate(weight, height, objective) {
    const currentWeight = Number(weight);
    const currentHeight = Number(height);
    if (!currentWeight || !currentHeight) {
      return null;
    }
    const idealWeight = (currentHeight - 100) * 0.9;
    let targetWeight = idealWeight;
    let weeklyRate = 0.5;

    if (objective === 'increase') {
      targetWeight = currentWeight + Math.max(2, currentWeight * 0.05);
      weeklyRate = 0.3;
    } else if (objective === 'ideal') {
      targetWeight = idealWeight;
      weeklyRate = 0.4;
    }

    const difference = Math.abs(currentWeight - targetWeight);
    const days = Math.max(7, Math.ceil((difference / weeklyRate) * 7));
    const targetDate = new Date();
    targetDate.setDate(targetDate.getDate() + days);
    return targetDate;
  }

  function calculateIMC() {
    const heightInput = document.getElementById('taille');
    const weightInput = document.getElementById('poids');
    if (!heightInput || !weightInput) {
      return null;
    }

    const height = parseFloat(heightInput.value) || 175;
    const weight = parseFloat(weightInput.value) || 88;
    const imc = weight / ((height / 100) ** 2);
    const idealWeight = (height - 100) * 0.9;
    const objective = getSelectedObjective();
    const targetDate = calculateTargetDate(weight, height, objective);

    const imcValue = document.getElementById('imc-val');
    const idealValue = document.getElementById('ideal-val');
    const idealDiff = document.getElementById('ideal-diff');
    const targetDateNode = document.getElementById('target-date');
    const needle = document.getElementById('imc-needle');
    const status = document.getElementById('imc-status');

    if (imcValue) {
      imcValue.textContent = imc.toFixed(1);
    }
    if (idealValue) {
      idealValue.textContent = idealWeight.toFixed(1) + ' kg';
    }
    if (idealDiff) {
      const delta = weight - idealWeight;
      idealDiff.textContent = delta > 0 ? 'A perdre : ' + delta.toFixed(1) + ' kg' : 'A gagner : ' + Math.abs(delta).toFixed(1) + ' kg';
    }
    if (targetDateNode) {
      targetDateNode.textContent = targetDate ? 'Atteinte estimee : ' + targetDate.toLocaleDateString('fr-FR') : 'Atteinte estimee : --';
    }
    if (needle) {
      const pct = Math.min(Math.max((imc - 10) / 30 * 100, 2), 96);
      needle.style.left = 'calc(' + pct + '% - 2px)';
    }
    if (status) {
      if (imc < 18.5) {
        status.textContent = 'Insuffisance ponderale';
        status.style.background = '#E6F1FB';
        status.style.color = '#0C447C';
      } else if (imc < 25) {
        status.textContent = 'Poids normal';
        status.style.background = '#E1F5EE';
        status.style.color = '#0F6E56';
      } else if (imc < 30) {
        status.textContent = 'Surpoids modere';
        status.style.background = '#FAEEDA';
        status.style.color = '#633806';
      } else {
        status.textContent = 'Obesite';
        status.style.background = '#FCEBEB';
        status.style.color = '#791F1F';
      }
    }

    return imc;
  }

  function renderSuggestedRegimes(objective, container) {
    const db = ensureDb();
    const regimes = db.regimes.filter((regime) => regime.objective === objective || objective === 'all');
    if (!container) {
      return regimes;
    }
    container.innerHTML = regimes
      .map((regime) => '<div class="regime-item"><div class="regime-name">' + regime.name + '</div><div class="regime-sub">' + regime.macros.viande + '% viande, ' + regime.macros.poisson + '% poisson, ' + regime.macros.volaille + '% volaille</div><div class="regime-price">' + regime.goldPrice.toLocaleString('fr-FR') + ' Ar</div></div>')
      .join('');
    return regimes;
  }

  function getSuggestedRegimes(objective) {
    const selectedObjective = objective || getSelectedObjective();
    return renderSuggestedRegimes(selectedObjective, document.getElementById('suggested-regimes'));
  }

  function registerUser() {
    const db = ensureDb();
    const tempUser = db.tempUser || getCurrentUser();
    if (!tempUser) {
      alert('Aucune inscription en cours.');
      return false;
    }

    const heightInput = document.getElementById('taille');
    const weightInput = document.getElementById('poids');
    const height = parseFloat(heightInput ? heightInput.value : tempUser.height) || tempUser.height || 175;
    const weight = parseFloat(weightInput ? weightInput.value : tempUser.weight) || tempUser.weight || 88;
    const objective = getSelectedObjective();
    const imc = calculateIMC();

    const user = {
      email: normalizeEmail(tempUser.email),
      password: tempUser.password,
      firstName: tempUser.firstName,
      lastName: tempUser.lastName,
      gender: tempUser.gender,
      role: 'user',
      gold: false,
      wallet: 85000,
      objective,
      height,
      weight,
      imc,
    };

    const existingIndex = db.users.findIndex((entry) => normalizeEmail(entry.email) === user.email);
    if (existingIndex >= 0) {
      db.users[existingIndex] = { ...db.users[existingIndex], ...user };
    } else {
      db.users.push(user);
    }
    db.weightHistory[user.email] = db.weightHistory[user.email] || [];
    db.weightHistory[user.email].push({ date: new Date().toISOString().slice(0, 10), weight });
    db.tempUser = null;
    saveDb(db);
    setSession({ email: user.email });
    window.location.href = 'idfit_dashboard_user.html';
    return true;
  }

  function authenticate() {
    const emailInput = document.getElementById('login-email') || document.querySelector('.right input[type="email"]');
    const passwordInput = document.getElementById('login-password') || document.querySelector('.right input[type="password"]');
    const message = document.getElementById('login-message');
    const email = normalizeEmail(emailInput ? emailInput.value : '');
    const password = String(passwordInput ? passwordInput.value : '');
    const db = ensureDb();
    const user = db.users.find((entry) => normalizeEmail(entry.email) === email && entry.password === password);

    if (!user) {
      setMessage(message, 'Identifiants invalides', 'bad');
      return false;
    }

    setSession({ email: user.email });
    setMessage(message, 'Connexion reussie', 'ok');
    redirectByRole(user);
    return true;
  }

  function redirectByRole(user) {
    const role = user && user.role === 'admin' ? 'admin' : 'user';
    window.location.href = role === 'admin' ? 'idfit_admin.html' : 'idfit_dashboard_user.html';
  }

  function getWeightSeries() {
    const currentUser = getCurrentUser();
    const db = ensureDb();
    const history = db.weightHistory[normalizeEmail(currentUser.email)] || [];
    if (history.length >= 2) {
      return history;
    }
    return [
      { date: 'S1', weight: 88 },
      { date: 'S2', weight: 87.2 },
      { date: 'S3', weight: 86.5 },
      { date: 'S4', weight: 86 },
      { date: 'S5', weight: 85.5 },
      { date: 'S6', weight: 85.2 },
      { date: 'S7', weight: 85.2 },
    ];
  }

  function generateWeightChart() {
    const canvas = document.getElementById('weightChart');
    if (!canvas || typeof Chart === 'undefined') {
      return null;
    }
    if (canvas._chart) {
      canvas._chart.destroy();
    }
    const series = getWeightSeries();
    const labels = series.map((entry) => entry.date);
    const data = series.map((entry) => entry.weight);
    const weightGoal = data.length ? data[data.length - 1] - 0.5 : 85;
    canvas._chart = new Chart(canvas.getContext('2d'), {
      type: 'line',
      data: {
        labels,
        datasets: [
          {
            label: 'Poids (kg)',
            data,
            borderColor: '#663266',
            backgroundColor: 'rgba(102,50,102,0.08)',
            borderWidth: 2,
            pointBackgroundColor: '#663266',
            pointRadius: 4,
            tension: 0.4,
            fill: true,
          },
          {
            label: 'Objectif',
            data: labels.map((_, index) => Math.max(weightGoal, data[Math.min(index, data.length - 1)] - 0.2)),
            borderColor: '#A2A001',
            borderDash: [4, 4],
            borderWidth: 1.5,
            pointRadius: 0,
            tension: 0.4,
            fill: false,
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { labels: { font: { size: 11 }, boxWidth: 12 } },
          tooltip: { titleFont: { size: 11 }, bodyFont: { size: 11 } },
        },
        scales: {
          y: { ticks: { font: { size: 10 } }, grid: { color: 'rgba(0,0,0,0.04)' } },
          x: { ticks: { font: { size: 10 } }, grid: { display: false } },
        },
      },
    });
    return canvas._chart;
  }

  function updateWeightHistory() {
    const weightInput = document.getElementById('weight-value');
    const dateInput = document.getElementById('weight-date');
    const noteInput = document.getElementById('weight-note');
    const currentUser = getCurrentUser();
    if (!weightInput || !dateInput || !currentUser) {
      return false;
    }
    const weight = parseFloat(weightInput.value);
    if (!Number.isFinite(weight) || weight <= 0) {
      alert('Poids invalide');
      return false;
    }
    const entry = {
      date: dateInput.value || new Date().toISOString().slice(0, 10),
      weight,
      note: String(noteInput ? noteInput.value : ''),
    };
    const db = ensureDb();
    const email = normalizeEmail(currentUser.email);
    db.weightHistory[email] = db.weightHistory[email] || [];
    db.weightHistory[email].push(entry);
    db.transactions.push({ email, type: 'weight', amount: 0, label: 'Weight update', date: entry.date, meta: entry.note });
    const userIndex = db.users.findIndex((user) => normalizeEmail(user.email) === email);
    if (userIndex >= 0) {
      db.users[userIndex].weight = weight;
    }
    saveDb(db);
    generateWeightChart();
    alert('Poids enregistre');
    return true;
  }

  function checkSolde(amount) {
    const currentUser = getCurrentUser();
    const balance = Number(currentUser && currentUser.wallet ? currentUser.wallet : 0);
    return balance >= Number(amount || 0);
  }

  function applyGoldDiscount(price) {
    const currentUser = getCurrentUser();
    const value = Number(price || 0);
    return currentUser && currentUser.gold ? Math.round(value * (1 - ensureDb().systemConfig.goldDiscount)) : value;
  }

  function generatePDF(trigger) {
    const card = trigger && trigger.closest ? trigger.closest('.rcard') : null;
    const regimeName = card ? String(card.querySelector('.rc-name')?.textContent || 'Regime') : 'Regime';
    const objective = card ? String(card.querySelector('.obj-badge')?.textContent || 'Objectif') : 'Objectif';
    const sports = card ? Array.from(card.querySelectorAll('.sport-tag')).map((node) => node.textContent.trim()).join('<br>') : '';
    const macros = card ? Array.from(card.querySelectorAll('.mac')).map((node) => node.textContent.trim()).join('<br>') : '';
    const finalPrice = card ? String(card.querySelector('.price-final')?.textContent || '') : '';
    const popup = window.open('', '_blank', 'width=900,height=700');
    if (!popup) {
      alert('Popup bloquee. Utilisez l impression du navigateur.');
      return false;
    }
    popup.document.write('<html><head><title>' + regimeName + '</title><style>body{font-family:Arial,sans-serif;padding:32px}h1{margin-bottom:8px}p{margin:0 0 8px}</style></head><body><h1>' + regimeName + '</h1><p>' + objective + '</p><p>' + macros + '</p><p>' + sports + '</p><p>Prix: ' + finalPrice + ' Ar/mois</p><script>window.onload=function(){window.print();}</script></body></html>');
    popup.document.close();
    return true;
  }

  function subscribeRegime(trigger) {
    const card = trigger && trigger.closest ? trigger.closest('.rcard') : null;
    if (!card) {
      return false;
    }
    const priceText = String(card.dataset.basePrice || card.querySelector('.price-final')?.textContent || '0').replace(/\s+/g, '').replace('Ar', '').replace(',', '.');
    const price = applyGoldDiscount(parseFloat(priceText) || 0);
    const currentUser = getCurrentUser();
    if (!checkSolde(price)) {
      alert('Solde insuffisant');
      return false;
    }
    const db = ensureDb();
    const email = normalizeEmail(currentUser.email);
    const userIndex = db.users.findIndex((user) => normalizeEmail(user.email) === email);
    if (userIndex >= 0) {
      db.users[userIndex].wallet -= price;
    }
    db.transactions.push({ email, type: 'regime', amount: price, label: String(card.querySelector('.rc-name')?.textContent || 'Regime'), date: new Date().toISOString().slice(0, 10) });
    saveDb(db);
    updateFinanceBalance();
    updateDashboardSummary();
    alert('Regime souscrit');
    return true;
  }

  function validateCode(code) {
    const normalized = String(code || '').trim().toUpperCase();
    const db = ensureDb();
    return db.codes.find((entry) => entry.code.toUpperCase() === normalized && !entry.used) || null;
  }

  function updateFinanceBalance() {
    const currentUser = getCurrentUser();
    const balanceNode = document.getElementById('wallet-balance');
    if (balanceNode && currentUser) {
      balanceNode.textContent = Number(currentUser.wallet || 0).toLocaleString('fr-FR');
    }
    const goldButton = document.getElementById('gold-action');
    if (goldButton && currentUser) {
      updateButtonText(goldButton, currentUser.gold ? 'Vous etes deja membre Gold' : 'Devenir Gold');
    }
  }

  function creditWallet() {
    const codeInput = document.getElementById('wallet-code');
    const code = codeInput ? codeInput.value : '';
    const validCode = validateCode(code);
    if (!validCode) {
      alert('Code invalide ou deja utilise');
      return false;
    }

    const db = ensureDb();
    const currentUser = getCurrentUser();
    const email = normalizeEmail(currentUser.email);
    const userIndex = db.users.findIndex((user) => normalizeEmail(user.email) === email);
    if (userIndex >= 0) {
      db.users[userIndex].wallet = Number(db.users[userIndex].wallet || 0) + Number(validCode.amount || 0);
    }
    const codeIndex = db.codes.findIndex((entry) => entry.code === validCode.code);
    if (codeIndex >= 0) {
      db.codes[codeIndex].used = true;
    }
    db.transactions.push({ email, type: 'wallet', amount: validCode.amount, label: validCode.code, date: new Date().toISOString().slice(0, 10) });
    saveDb(db);
    updateFinanceBalance();
    alert('Compte credite');
    return true;
  }

  function upgradeToGold() {
    const db = ensureDb();
    const currentUser = getCurrentUser();
    const email = normalizeEmail(currentUser.email);
    const userIndex = db.users.findIndex((user) => normalizeEmail(user.email) === email);
    if (userIndex < 0) {
      return false;
    }
    if (db.users[userIndex].gold) {
      alert('Utilisateur deja Gold');
      return true;
    }
    const price = db.systemConfig.goldPrice;
    if (!checkSolde(price)) {
      alert('Solde insuffisant pour devenir Gold');
      return false;
    }
    db.users[userIndex].wallet -= price;
    db.users[userIndex].gold = true;
    db.transactions.push({ email, type: 'gold', amount: price, label: 'Gold activation', date: new Date().toISOString().slice(0, 10) });
    saveDb(db);
    setSession({ email });
    updateFinanceBalance();
    alert('Statut Gold active');
    return true;
  }

  function getGlobalStats() {
    const db = ensureDb();
    const users = db.users.filter((user) => user.role === 'user');
    const goldUsers = users.filter((user) => user.gold).length;
    const usedCodes = db.codes.filter((code) => code.used).length;
    const totalRevenue = db.transactions
      .filter((transaction) => transaction.type === 'regime' || transaction.type === 'gold')
      .reduce((sum, transaction) => sum + Number(transaction.amount || 0), 0);

    return {
      users: users.length,
      goldUsers,
      usedCodes,
      totalCodes: db.codes.length,
      totalRevenue,
      byRegime: db.regimes.reduce((accumulator, regime) => {
        accumulator[regime.name] = (accumulator[regime.name] || 0) + 1;
        return accumulator;
      }, {}),
    };
  }

  function manageRegime(regime) {
    const db = ensureDb();
    const payload = regime || {};
    const name = String(payload.name || prompt('Nom du regime :') || '').trim();
    if (!name) {
      return false;
    }
    const objective = String(payload.objective || prompt('Objectif (reduce / increase / ideal) :') || 'reduce').trim();
    const price = Number(payload.price || prompt('Prix mensuel :') || 0);
    const goldPrice = Number(payload.goldPrice || Math.round(price * 0.85));
    const existingIndex = db.regimes.findIndex((entry) => entry.name.toLowerCase() === name.toLowerCase());
    const item = { name, objective, price, goldPrice, macros: payload.macros || { viande: 30, poisson: 40, volaille: 30 }, sports: payload.sports || [] };
    if (existingIndex >= 0) {
      db.regimes[existingIndex] = item;
    } else {
      db.regimes.push(item);
    }
    saveDb(db);
    return item;
  }

  function manageSport(sport) {
    const db = ensureDb();
    const payload = sport || {};
    const name = String(payload.name || prompt('Nom du sport :') || '').trim();
    if (!name) {
      return false;
    }
    const objective = String(payload.objective || prompt('Objectif :') || 'reduce').trim();
    const regime = String(payload.regime || prompt('Regime associe :') || '').trim();
    const existingIndex = db.sports.findIndex((entry) => entry.name.toLowerCase() === name.toLowerCase());
    const item = { name, objective, regime };
    if (existingIndex >= 0) {
      db.sports[existingIndex] = item;
    } else {
      db.sports.push(item);
    }
    saveDb(db);
    return item;
  }

  function updateSystemConfig(patch) {
    const db = ensureDb();
    db.systemConfig = { ...db.systemConfig, ...(patch || {}) };
    saveDb(db);
    return db.systemConfig;
  }

  function listAllCodes() {
    const db = ensureDb();
    return db.codes.slice();
  }

  function refreshAdminMetrics() {
    const stats = getGlobalStats();
    const metrics = document.querySelectorAll('.metrics .met-val');
    if (metrics[0]) {
      metrics[0].textContent = String(stats.users);
    }
    if (metrics[1]) {
      metrics[1].textContent = String(stats.goldUsers);
    }
    if (metrics[2]) {
      metrics[2].textContent = stats.totalRevenue.toLocaleString('fr-FR');
    }
    if (metrics[3]) {
      metrics[3].innerHTML = stats.usedCodes + ' <span style="font-size:14px;font-weight:400;color:var(--txt3)">/ ' + stats.totalCodes + '</span>';
    }
  }

  function initConnexionPage() {
    const emailInput = document.getElementById('login-email') || document.querySelector('.right input[type="email"]');
    const passwordInput = document.getElementById('login-password') || document.querySelector('.right input[type="password"]');
    const button = document.querySelector('.right .btn-main');
    if (button) {
      button.onclick = authenticate;
    }
    if (emailInput) {
      emailInput.addEventListener('input', () => {
        const db = ensureDb();
        const user = db.users.find((entry) => normalizeEmail(entry.email) === normalizeEmail(emailInput.value));
        const message = document.getElementById('login-message');
        if (!isValidEmail(emailInput.value)) {
          setMessage(message, 'Adresse email invalide', 'bad');
          return;
        }
        if (user) {
          setMessage(message, 'Compte reconnu. Entrez le mot de passe.', 'ok');
        } else {
          setMessage(message, 'Aucun compte correspondant', 'bad');
        }
      });
    }
    if (passwordInput) {
      passwordInput.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
          authenticate();
        }
      });
    }
  }

  function initIdentityPage() {
    const emailInput = document.getElementById('identity-email');
    const buttons = document.querySelectorAll('.genre-btn');
    const continueButton = document.querySelector('.btn-row .btn-main');
    if (emailInput) {
      emailInput.addEventListener('input', () => checkEmailUnique(emailInput.value));
    }
    buttons.forEach((button) => {
      button.addEventListener('click', () => {
        buttons.forEach((item) => item.classList.remove('on'));
        button.classList.add('on');
      });
    });
    if (continueButton) {
      continueButton.onclick = saveTempUser;
    }
  }

  function initHealthPage() {
    const heightInput = document.getElementById('taille');
    const weightInput = document.getElementById('poids');
    const continueButton = document.querySelector('.btn-main');
    const objectiveCards = document.querySelectorAll('.obj-item');
    if (heightInput) {
      heightInput.addEventListener('input', calculateIMC);
    }
    if (weightInput) {
      weightInput.addEventListener('input', calculateIMC);
    }
    objectiveCards.forEach((card) => {
      card.addEventListener('click', () => {
        objectiveCards.forEach((item) => item.classList.remove('on'));
        card.classList.add('on');
        calculateIMC();
      });
    });
    if (continueButton) {
      continueButton.onclick = registerUser;
    }
    calculateIMC();
  }

  function updateDashboardSummary() {
    const currentUser = getCurrentUser();
    if (!currentUser) {
      return;
    }
    const weightNode = document.querySelector('.met-val.met-accent');
    const objectiveNode = document.querySelectorAll('.met-val')[1];
    const calorieNode = document.querySelectorAll('.met-val')[2];
    const walletNode = document.querySelector('.wallet');
    if (weightNode) {
      weightNode.innerHTML = Number(currentUser.weight || 0).toFixed(1) + ' <span style="font-size:13px;font-weight:400">kg</span>';
    }
    if (objectiveNode) {
      objectiveNode.textContent = getSelectedObjectiveLabel(currentUser.objective);
    }
    if (calorieNode) {
      calorieNode.textContent = currentUser.objective === 'increase' ? '2 600' : currentUser.objective === 'ideal' ? '2 300' : '2 100';
    }
    if (walletNode) {
      walletNode.innerHTML = '<i class="ti ti-wallet" aria-hidden="true"></i> ' + Number(currentUser.wallet || 0).toLocaleString('fr-FR') + ' Ar';
    }
  }

  function initDashboardPage() {
    const saveButton = document.querySelector('.btn-save');
    if (saveButton) {
      saveButton.onclick = updateWeightHistory;
    }
    generateWeightChart();
    updateDashboardSummary();
  }

  function initRegimesPage() {
    const chips = document.querySelectorAll('.filter-chip');
    const cards = document.querySelectorAll('.rcard');
    const subscribeButtons = document.querySelectorAll('.btn-sub');
    const pdfButtons = document.querySelectorAll('.btn-pdf');

    cards.forEach((card) => {
      const objectiveBadge = card.querySelector('.obj-badge');
      if (objectiveBadge) {
        const text = objectiveBadge.textContent.toLowerCase();
        card.dataset.objective = text.includes('augmenter') ? 'increase' : text.includes('ideal') ? 'ideal' : 'reduce';
      }
      const priceOrigin = card.querySelector('.price-orig') || card.querySelector('.price-final');
      const priceFinal = card.querySelector('.price-final');
      if (priceOrigin) {
        card.dataset.basePrice = String(priceOrigin.textContent || '').replace(/\s+/g, '').replace('Ar', '').replace(',', '.');
        if (priceFinal) {
          priceFinal.textContent = Number(applyGoldDiscount(card.dataset.basePrice)).toLocaleString('fr-FR');
        }
      }
    });

    chips.forEach((chip) => {
      chip.addEventListener('click', () => {
        chips.forEach((item) => item.classList.remove('on'));
        chip.classList.add('on');
        const label = chip.textContent.toLowerCase();
        const objective = label.includes('augmenter') ? 'increase' : label.includes('ideal') ? 'ideal' : label.includes('re') ? 'reduce' : 'all';
        cards.forEach((card) => {
          const match = objective === 'all' || card.dataset.objective === objective;
          card.style.display = match ? '' : 'none';
        });
        getSuggestedRegimes(objective);
      });
    });

    subscribeButtons.forEach((button) => {
      button.onclick = () => subscribeRegime(button);
    });
    pdfButtons.forEach((button) => {
      button.onclick = () => generatePDF(button);
    });
    getSuggestedRegimes();
  }

  function initFinancePage() {
    const codeInput = document.getElementById('wallet-code');
    const creditButton = document.getElementById('wallet-credit');
    const goldButton = document.getElementById('gold-action');
    if (creditButton) {
      creditButton.onclick = creditWallet;
    }
    if (goldButton) {
      goldButton.onclick = upgradeToGold;
    }
    if (codeInput) {
      codeInput.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
          creditWallet();
        }
      });
    }
    updateFinanceBalance();
  }

  function initAdminCharts() {
    if (typeof Chart === 'undefined') {
      return;
    }
    const regimeCanvas = document.getElementById('regimeChart');
    const revenueCanvas = document.getElementById('revenueChart');
    const stats = getGlobalStats();
    if (regimeCanvas) {
      if (regimeCanvas._chart) {
        regimeCanvas._chart.destroy();
      }
      regimeCanvas._chart = new Chart(regimeCanvas.getContext('2d'), {
        type: 'doughnut',
        data: {
          labels: Object.keys(stats.byRegime),
          datasets: [
            {
              data: Object.values(stats.byRegime),
              backgroundColor: ['#663266', '#A2A001', '#989866', '#666698', '#7a3d7a'],
              borderWidth: 0,
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { position: 'right', labels: { font: { size: 10 }, boxWidth: 10, padding: 8 } },
          },
        },
      });
    }
    if (revenueCanvas) {
      if (revenueCanvas._chart) {
        revenueCanvas._chart.destroy();
      }
      const db = ensureDb();
      const monthly = db.transactions.reduce((accumulator, transaction) => {
        const key = transaction.date.slice(0, 7);
        accumulator[key] = (accumulator[key] || 0) + (transaction.type === 'wallet' ? 0 : Number(transaction.amount || 0));
        return accumulator;
      }, {});
      const sortedKeys = Object.keys(monthly).sort();
      revenueCanvas._chart = new Chart(revenueCanvas.getContext('2d'), {
        type: 'bar',
        data: {
          labels: sortedKeys.length ? sortedKeys : ['Jan', 'Fev', 'Mar', 'Avr', 'Mai'],
          datasets: [
            {
              label: 'Revenus (Ar)',
              data: sortedKeys.length ? sortedKeys.map((key) => monthly[key]) : [120000, 150000, 180000, 210000, 335000],
              backgroundColor: 'rgba(102,50,102,0.7)',
              borderRadius: 4,
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: { legend: { display: false } },
          scales: {
            y: { ticks: { font: { size: 10 }, callback: (value) => value / 1000 + 'k' }, grid: { color: 'rgba(0,0,0,0.04)' } },
            x: { ticks: { font: { size: 10 } }, grid: { display: false } },
          },
        },
      });
    }
    refreshAdminMetrics();
    bindAdminActions();
  }

  function bindAdminActions() {
    document.querySelectorAll('.btn-add').forEach((button) => {
      const label = button.textContent.toLowerCase();
      button.onclick = () => {
        if (label.includes('ajouter')) {
          manageRegime();
          initAdminCharts();
        } else if (label.includes('generer') || label.includes('générer')) {
          const db = ensureDb();
          const nextIndex = db.codes.length + 1;
          const code = {
            code: 'IDFT-' + String(1000 + nextIndex),
            amount: 50000,
            used: false,
          };
          db.codes.push(code);
          saveDb(db);
          refreshAdminMetrics();
          alert('Code genere : ' + code.code);
        }
      };
    });

    document.querySelectorAll('.param-edit').forEach((button) => {
      button.onclick = () => {
        const label = String(button.previousElementSibling?.previousElementSibling?.textContent || '');
        const value = prompt('Nouvelle valeur pour ' + label + ' :', String(button.previousElementSibling?.textContent || ''));
        if (value !== null && value !== '') {
          updateSystemConfig({ [label]: value });
          button.previousElementSibling.textContent = value;
        }
      };
    });

    document.querySelectorAll('.btn-val').forEach((button) => {
      button.onclick = () => {
        const row = button.closest('tr');
        const code = row ? String(row.children[0].textContent).trim() : '';
        const db = ensureDb();
        const index = db.codes.findIndex((entry) => entry.code === code);
        if (index >= 0) {
          db.codes[index].used = true;
          saveDb(db);
          refreshAdminMetrics();
          row.children[2].innerHTML = '<span class="badge bd-used">Utilise</span>';
          row.children[3].textContent = '—';
        }
      };
    });

    document.querySelectorAll('.btn-edit').forEach((button) => {
      button.onclick = () => {
        const row = button.closest('tr');
        if (!row) {
          return;
        }
        const name = row.children[0].textContent.trim();
        const objective = row.children[1].textContent.trim();
        const price = row.children[2].textContent.replace(/\D+/g, '');
        manageRegime({ name, objective: objective.toLowerCase().includes('augmenter') ? 'increase' : objective.toLowerCase().includes('imc') ? 'ideal' : 'reduce', price: Number(price) });
        initAdminCharts();
      };
    });

    document.querySelectorAll('.btn-del').forEach((button) => {
      button.onclick = () => {
        const row = button.closest('tr');
        if (!row) {
          return;
        }
        const name = row.children[0].textContent.trim();
        const db = ensureDb();
        db.regimes = db.regimes.filter((entry) => entry.name.toLowerCase() !== name.toLowerCase());
        saveDb(db);
        row.remove();
        initAdminCharts();
      };
    });
  }

  function bindDeclarativeActions() {
    document.addEventListener('click', (event) => {
      const promptTarget = event.target.closest('[data-prompt]');
      if (promptTarget) {
        const prompt = promptTarget.dataset.prompt;
        if (prompt && typeof window.sendPrompt === 'function') {
          event.preventDefault();
          window.sendPrompt(prompt);
        }
        return;
      }

      const actionTarget = event.target.closest('[data-action]');
      if (!actionTarget) {
        return;
      }

      const actionName = actionTarget.dataset.action;
      const action = window[actionName];
      if (typeof action === 'function') {
        event.preventDefault();
        action();
      }
    });
  }

  function initApp() {
    bindDeclarativeActions();

    if (document.querySelector('.split .right')) {
      initConnexionPage();
    }
    if (document.getElementById('identity-email')) {
      initIdentityPage();
    }
    if (document.getElementById('taille')) {
      initHealthPage();
    }
    if (document.querySelector('.wallet-hero')) {
      initFinancePage();
    }
    if (document.querySelector('.cards .rcard')) {
      initRegimesPage();
    }
    if (document.getElementById('weightChart')) {
      initDashboardPage();
    }
    if (document.getElementById('regimeChart') || document.getElementById('revenueChart')) {
      initAdminCharts();
    }
  }

  window.checkEmailUnique = checkEmailUnique;
  window.saveTempUser = saveTempUser;
  window.calculateIMC = calculateIMC;
  window.calcImc = calculateIMC;
  window.calculateTargetDate = calculateTargetDate;
  window.registerUser = registerUser;
  window.authenticate = authenticate;
  window.redirectByRole = redirectByRole;
  window.getSuggestedRegimes = getSuggestedRegimes;
  window.updateWeightHistory = updateWeightHistory;
  window.generateWeightChart = generateWeightChart;
  window.checkSolde = checkSolde;
  window.applyGoldDiscount = applyGoldDiscount;
  window.generatePDF = generatePDF;
  window.validateCode = validateCode;
  window.creditWallet = creditWallet;
  window.upgradeToGold = upgradeToGold;
  window.getGlobalStats = getGlobalStats;
  window.manageRegime = manageRegime;
  window.manageSport = manageSport;
  window.updateSystemConfig = updateSystemConfig;
  window.listAllCodes = listAllCodes;
  window.subscribeRegime = subscribeRegime;
  window.initAdminCharts = initAdminCharts;
  window.updateDashboardSummary = updateDashboardSummary;

  document.addEventListener('DOMContentLoaded', initApp);
})();
