# Todo détaillé — Projet NutriPlan S4
> Deadline : **lundi 11 mai 2026**  
> Stack : PHP + CodeIgniter · HTML/CSS · JavaScript/AJAX · MySQL/PostgreSQL

---

## Progression globale
- [ ] Base de données (priorité 1)
- [ ] Inscription & Connexion
- [ ] Formulaire d'objectif & IMC
- [ ] Dashboard utilisateur
- [ ] Régimes & PDF
- [ ] Cash & option Gold
- [ ] Dashboard admin
- [ ] Livraison & Git

---

## 🗄️ Base de données — À faire EN PREMIER

- [ ] **Table `users`**  
  `id, nom, prenom, genre, email, password_hash, taille, poids, is_gold, wallet_balance, role, created_at`

- [ ] **Table `regimes`**  
  `id, nom, description, objectif, pct_viande, pct_poisson, pct_volaille, calories_jour`

- [ ] **Table `prix_regime`**  
  `id, regime_id, duree_mois, prix`

- [ ] **Table `sports`**  
  `id, nom, description, duree_min, frequence_semaine, regime_id`

- [ ] **Table `weight_history`**  
  `id, user_id, poids, date_mesure`

- [ ] **Table `codes`**  
  `id, code, valeur, is_used, used_by, used_at`

- [ ] **Table `subscriptions`**  
  `id, user_id, regime_id, duree_mois, prix_paye, date_debut`

- [ ] **Table `config_system`**  
  `cle, valeur` — pour prix Gold, % remise, seuils IMC

- [ ] **Données minimales (seed SQL)**  
  5 utilisateurs · 15 codes · 5 régimes · 5 activités sportives

---

## 🔐 Inscription & Connexion

### Page 1 — Identité
- [ ] Formulaire HTML/CSS : nom, prénom, genre (radio), email, mot de passe
- [ ] Validation email en temps réel côté JS (format)
- [ ] `checkEmailUnique()` — vérification unicité email via AJAX → PHP → SQL
- [ ] `saveTempUser()` — sauvegarde temporaire en session PHP avant étape 2

### Page 2 — Santé
- [ ] Formulaire HTML/CSS : taille (cm), poids (kg) avec unités affichées
- [ ] `calculateIMC()` — calcul IMC live en JS : `poids / (taille/100)²`
- [ ] `registerUser()` — INSERT en base avec hash mot de passe (`password_hash()`)

### Connexion
- [ ] Formulaire HTML/CSS : email, mot de passe, checkbox "se souvenir de moi"
- [ ] `authenticate()` — vérifier hash, démarrer session PHP
- [ ] `redirectByRole()` — rediriger vers dashboard user ou admin selon `role`

---

## 🎯 Formulaire d'objectif & IMC

- [ ] Affichage IMC actuel (calculé depuis profil en base)
- [ ] Affichage poids idéal (formule Lorentz selon genre et taille)
- [ ] Barre de progression IMC visuelle (vert / orange / rouge)
- [ ] Sélection objectif : Réduire / Augmenter / Atteindre IMC idéal (radio)
- [ ] `getSuggestedRegimes()` — filtrage SQL des régimes selon objectif choisi
- [ ] `calculateTargetDate()` — estimation durée basée sur delta poids et rythme mensuel du régime

---

## 🏠 Dashboard utilisateur

### Layout & structure
- [ ] Layout sidebar fixe + zone main content (HTML/CSS)
- [ ] Sidebar : liens vers Régimes, Graphique, Portefeuille
- [ ] Badge statut Gold visible dans le header (conditionnel si `is_gold = 1`)

### Bloc infos personnelles
- [ ] Afficher poids actuel, objectif, calories/jour

### Suivi du poids
- [ ] Formulaire : input poids (kg) + date picker + bouton [Enregistrer]
- [ ] `updateWeightHistory()` — INSERT dans `weight_history` via AJAX, retour JSON
- [ ] `generateWeightChart()` — SELECT poids + date triés, formatés pour Chart.js
- [ ] Intégration Chart.js — courbe d'évolution du poids (ligne temporelle)

---

## 🥗 Régimes & export PDF

- [ ] Liste des régimes suggérés (cards : nom, durée, prix, % viande/poisson/volaille)
- [ ] `checkSolde()` — comparer `wallet_balance` vs prix régime avant achat
- [ ] `applyGoldDiscount()` — si `is_gold = 1` → prix × 0.85
- [ ] Souscription régime — UPDATE wallet + INSERT dans `subscriptions`
- [ ] `generatePDF()` — export PDF via FPDF ou DomPDF (régime, macros, sports, durée)

---

## 💰 Cash & option Gold

### Portefeuille
- [ ] Page HTML/CSS : affichage solde, champ code, bouton [Encaisser]
- [ ] `validateCode()` — vérifier existence + non-utilisé dans table `codes` (AJAX)
- [ ] `creditWallet()` — UPDATE `wallet_balance` + marquer code `is_used = 1`

### Option Gold
- [ ] Page / modale Gold : prix affiché, avantages listés, bouton [Devenir Gold]
- [ ] `upgradeToGold()` — vérifier solde ≥ prix Gold, UPDATE `is_gold = 1` + débit

---

## ⚙️ Dashboard admin

### Authentification
- [ ] Page login admin séparée avec vérification rôle admin obligatoire

### Statistiques
- [ ] Tableau de bord avec graphes (Chart.js)
- [ ] `getGlobalStats()` — répartition users par régime, total revenus

### CRUD Régimes
- [ ] `manageRegime()` — créer / modifier / supprimer régime
- [ ] Champs : nom, description, objectif cible, % viande, % poisson, % volaille
- [ ] Gestion prix variant selon durée (table `prix_regime`)

### CRUD Sports
- [ ] `manageSport()` — créer / modifier / supprimer activité sportive
- [ ] Lier un sport à un régime ou un objectif

### Gestion codes portefeuille
- [ ] `listAllCodes()` — liste : tous / non utilisés / utilisés
- [ ] Bouton valider un code manuellement depuis l'admin

### Paramètres système
- [ ] `updateSystemConfig()` — modifier prix Gold, % remise, seuils IMC
- [ ] Interface table `config_system` (clé → valeur)

---

## 🚀 Livraison & Git

- [ ] Initialiser le repo GitLab/GitHub avec README et `.gitignore`
- [ ] **Commits réguliers** tout au long du projet (pas tout à la fin !)
- [ ] Travailler sur des branches feature, merger dans `main`
- [ ] Fichier `nutriplan.sql` livrable (CREATE TABLE + INSERT données minimales)
- [ ] Liste membres groupe sur Google Sheet (nom, prénom, rôle)
- [ ] Suivi des tâches sur Google Sheet (tâche, responsable, statut, date)
- [ ] Remplir le formulaire de livraison Google Forms avant le **11 mai 2026**

---

## 📌 Ordre recommandé

1. Base de données (tables + seed)
2. Inscription / Connexion
3. Formulaire objectif + IMC
4. Dashboard utilisateur (poids + graphe)
5. Régimes + souscription + PDF
6. Cash + Gold
7. Dashboard admin (CRUD + stats)
8. Tests + commits + livraison
