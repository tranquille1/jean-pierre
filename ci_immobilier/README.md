# 🇨🇮 CI Immobilier - Application de Gestion Immobilière (PHP)

Application web de gestion immobilière spécialement conçue pour la **Côte d'Ivoire**, développée en **PHP** avec MySQL.

## ✅ Nouvelles fonctionnalités (Mise à jour récente)

### 🔐 Vérification des quittances par QR Code
- **QR Code unique** généré automatiquement sur chaque quittance
- **Lien de vérification sécurisé** avec token cryptographique
- **Page de vérification dédiée** (`verify.php`) accessible par QR Code
- **Authentification en temps réel** : valide ou invalide la quittance
- **Historique des vérifications** suivi dans la base de données

### ✏️ Modification des éléments enregistrés
- **Modifier une propriété** : bouton dédié avec formulaire pré-rempli
- **Modifier un locataire** : mise à jour complète des informations
- **Modifier un paiement** : ajustement des montants et références
- **Validation sécurisée** avec confirmation avant modification

### 🖨️ Option d'impression améliorée
- **Bouton "Imprimer la quittance"** sur chaque page de quittance
- **Bouton "Ouvrir pour impression"** pour afficher dans un nouvel onglet optimisé
- **Impression directe** depuis la liste des paiements et quittances
- **Format professionnel** avec signatures, cachet et QR Code de vérification
- **Téléchargement PDF** via la fonction d'impression du navigateur

### 🔘 Interface utilisateur entièrement révisée
- **Tous les boutons fonctionnels** avec icônes et libellés clairs
- **Groupes de boutons** avec `role="group"` pour une meilleure accessibilité
- **Statistiques enrichies** sur les pages Locataires et Paiements
- **Filtres intégrés** directement dans l'en-tête de la page Propriétés
- **Navigation fluide** entre les pages
- **Tooltips** sur tous les boutons d'action

## ✨ Fonctionnalités principales

### 🏘️ Gestion des Propriétés
- Enregistrement avec **communes ivoiriennes** (Cocody, Yopougon, Plateau, Marcory, Treichville, Adjamé, Abobo, Koumassi, Port-Bouët, Attécoubé, Bingerville, Songon, Anyama)
- Types de logements : Studio, Appartement, Villa, Duplex, Chambre, Local commercial, Terrain
- Suivi du statut (Disponible/Loué)
- Informations propriétaire avec téléphone

### 👥 Gestion des Locataires
- Profil complet avec **numéro CNI** (Carte Nationale d'Identité ivoirienne)
- Coordonnées complètes (téléphone format ivoirien, email, profession)
- Historique et date d'entrée
- Association automatique aux propriétés

### 💰 Gestion des Paiements (spécifique Côte d'Ivoire)
**Modes de paiement locaux :**
- 🟠 **Orange Money**
- 💛 **MTN MoMo**
- 💙 **Wave**
- 💵 Espèces
- 📝 Chèque
- 🏦 Virement bancaire

**Types de paiement :**
- Loyer
- Caution
- **Électricité (CIE)** - Compagnie Ivoirienne d'Électricité
- **Eau (SODECI)** - Société de Distribution d'Eau de la Côte d'Ivoire
- Frais d'entretien

### 📄 Génération de Quittances
- Quittances automatiques avec numéro unique (format: QTC-YYYYMMDD-ID)
- Format professionnel imprimable
- Référence de transaction Mobile Money
- Bouton d'impression intégré
- Signatures locataire/agence

## 📁 Structure du projet

```
ci_immobilier/
├── config/
│   └── database.php          # Configuration BDD et constantes
├── includes/
│   └── functions.php         # Fonctions utilitaires
├── templates/
│   └── layout.php            # Template de base
├── assets/
│   ├── css/
│   │   └── style.css         # Styles personnalisés
│   └── js/
│       └── app.js            # JavaScript
├── index.php                 # Tableau de bord
├── install.php               # Installation BDD
├── proprietes.php            # Liste des propriétés
├── ajouter_propriete.php     # Ajouter propriété
├── locataires.php            # Liste des locataires
├── ajouter_locataire.php     # Ajouter locataire
├── paiements.php             # Liste des paiements
├── ajouter_paiement.php      # Ajouter paiement
├── quittances.php            # Liste des quittances
└── quittance.php             # Détail/Impression quittance
```

## 🚀 Installation

### Prérequis
- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur / MariaDB
- Serveur web (Apache, Nginx) ou XAMPP/WAMP/MAMP

### Étapes d'installation

1. **Copier les fichiers** dans votre dossier web :
   ```bash
   cp -r ci_immobilier /var/www/html/
   ```

2. **Configurer la base de données** :
   - Éditez `config/database.php` :
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'ci_immobilier');
   define('DB_USER', 'root');
   define('DB_PASS', 'votre_mot_de_passe');
   ```

3. **Créer la base de données** :
   ```sql
   CREATE DATABASE ci_immobilier CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

4. **Lancer l'installation** :
   - Accédez à `http://localhost/ci_immobilier/install.php`
   - Les tables seront créées automatiquement

5. **Accéder à l'application** :
   - Rendez-vous sur `http://localhost/ci_immobilier/`

## 🎨 Design

- Couleurs inspirées du drapeau ivoirien (**Orange, Blanc, Vert**)
- Interface moderne et responsive avec Bootstrap 5
- Badges colorés pour les modes de paiement Mobile Money
- Navigation intuitive

## 📱 Technologies utilisées

- **Backend** : PHP 7.4+
- **Base de données** : MySQL/MariaDB
- **Frontend** : HTML5, CSS3, JavaScript
- **Framework CSS** : Bootstrap 5.3
- **Icônes** : Bootstrap Icons

## 🔐 Sécurité

- Protection contre les injections SQL (requêtes préparées PDO)
- Échappement des sorties (htmlspecialchars)
- Nettoyage des entrées utilisateur
- Validation des formulaires côté client et serveur

## 📊 Tableau de bord

Le tableau de bord affiche :
- Nombre total de propriétés
- Propriétés disponibles et louées
- Nombre de locataires
- Revenus du mois et totaux
- Dernières propriétés ajoutées
- Derniers paiements enregistrés

## 🖨️ Impression des quittances

- Format A4 optimisé
- En-tête personnalisé avec drapeau ivoirien
- Informations complètes du locataire (CNI, téléphone)
- Détails de la propriété
- Montant en FCFA bien visible
- Section signatures
- Pied de page professionnel

## 🇨🇮 Spécificités ivoiriennes

1. **Communes d'Abidjan** intégrées
2. **Format téléphone ivoirien** (+225 07 XX XX XX XX)
3. **Mobile Money** (Orange Money, MTN MoMo, Wave)
4. **CNI** (Carte Nationale d'Identité)
5. **CIE & SODECI** pour les factures d'électricité et d'eau
6. **Devise FCFA** avec formatage approprié

## 📝 Licence

Ce projet est open source et peut être utilisé librement.

---

Développé avec ❤️ pour la Côte d'Ivoire 🇨🇮

## 📁 Structure complète du projet

```
ci_immobilier/
├── config/
│   └── database.php          # Configuration BDD + table quittances
├── includes/
│   └── functions.php         # Fonctions utilitaires + QR Code & tokens
├── templates/
│   └── layout.php            # Template de base
├── assets/
│   ├── css/
│   │   └── style.css         # Styles personnalisés
│   └── js/
│       └── app.js            # JavaScript
├── index.php                 # Tableau de bord
├── install.php               # Installation BDD (inclut table quittances)
├── verify.php                # ⭐ NOUVEAU: Page de vérification QR Code
├── proprietes.php            # Liste des propriétés
├── ajouter_propriete.php     # Ajouter propriété
├── locataires.php            # Liste des locataires
├── ajouter_locataire.php     # Ajouter locataire
├── paiements.php             # Liste des paiements
├── ajouter_paiement.php      # Ajouter paiement (+ génération quittance auto)
├── quittances.php            # Liste des quittances
└── quittance.php             # Détail/Impression quittance avec QR Code
```

## 🚀 Installation

### Prérequis
- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur / MariaDB
- Serveur web (Apache, Nginx) ou XAMPP/WAMP/MAMP

### Étapes d'installation

1. **Copier les fichiers** dans votre dossier web :
   ```bash
   cp -r ci_immobilier /var/www/html/
   ```

2. **Configurer la base de données** :
   - Éditez `config/database.php` :
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'ci_immobilier');
   define('DB_USER', 'root');
   define('DB_PASS', 'votre_mot_de_passe');
   ```

3. **Créer la base de données** :
   ```sql
   CREATE DATABASE ci_immobilier CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

4. **Lancer l'installation** :
   - Accédez à `http://localhost/ci_immobilier/install.php`
   - Les tables seront créées automatiquement (incluant `quittances`)

5. **Accéder à l'application** :
   - Rendez-vous sur `http://localhost/ci_immobilier/`

## 🔐 Comment fonctionne la vérification par QR Code ?

1. **Génération automatique** : Lors de l'enregistrement d'un paiement, une quittance est créée avec :
   - Un numéro unique (ex: QTC-20250117-0001)
   - Un token cryptographique sécurisé (32 caractères hexadécimaux)

2. **QR Code intégré** : Chaque quittance imprimée contient un QR Code qui encode :
   - L'URL complète de vérification avec ID et token
   - Exemple : `http://votre-site.ci/verify.php?id=1&token=a1b2c3d4e5f6...`

3. **Vérification en ligne** : Toute personne scannant le QR Code :
   - Est redirigée vers la page `verify.php`
   - Voit les détails complets de la quittance si elle est valide
   - Reçoit une alerte si la quittance est invalide ou falsifiée

4. **Suivi des vérifications** : La première vérification marque la quittance comme "verified" dans la base.

## 🎨 Design

- Couleurs inspirées du drapeau ivoirien (**Orange, Blanc, Vert**)
- Interface moderne et responsive avec Bootstrap 5
- Badges colorés pour les modes de paiement Mobile Money
- Navigation intuitive
- QR Codes générés via API publique (qrserver.com)

## 📱 Technologies utilisées

- **Backend** : PHP 7.4+
- **Base de données** : MySQL/MariaDB (4 tables : proprietes, locataires, paiements, quittances)
- **Frontend** : HTML5, CSS3, JavaScript
- **Framework CSS** : Bootstrap 5.3
- **Icônes** : Bootstrap Icons
- **QR Codes** : API qrserver.com

## 🔐 Sécurité

- Protection contre les injections SQL (requêtes préparées PDO)
- Échappement des sorties (htmlspecialchars)
- Nettoyage des entrées utilisateur
- Validation des formulaires côté client et serveur
- Tokens cryptographiques uniques pour chaque quittance
- Protection contre la falsification des quittances

## 📊 Tableau de bord

Le tableau de bord affiche :
- Nombre total de propriétés
- Propriétés disponibles et louées
- Nombre de locataires
- Revenus du mois et totaux
- Dernières propriétés ajoutées
- Derniers paiements enregistrés

## 🖨️ Impression des quittances

- Format A4 optimisé
- En-tête personnalisé avec drapeau ivoirien
- Informations complètes du locataire (CNI, téléphone)
- Détails de la propriété
- Montant en FCFA bien visible
- Section signatures (locataire + agence)
- **QR Code de vérification** intégré
- Pied de page professionnel

## 🇨🇮 Spécificités ivoiriennes

1. **Communes d'Abidjan** intégrées (13 communes)
2. **Format téléphone ivoirien** (+225 07 XX XX XX XX)
3. **Mobile Money** (Orange Money 🟠, MTN MoMo 💛, Wave 💙)
4. **CNI** (Carte Nationale d'Identité)
5. **CIE & SODECI** pour les factures d'électricité et d'eau
6. **Devise FCFA** avec formatage approprié

## 📝 Licence

Ce projet est open source et peut être utilisé librement.

---

Développé avec ❤️ pour la Côte d'Ivoire 🇨🇮
