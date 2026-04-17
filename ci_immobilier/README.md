# 🇨🇮 CI Immobilier - Application de Gestion Immobilière (PHP)

Application web de gestion immobilière spécialement conçue pour la **Côte d'Ivoire**, développée en **PHP** avec MySQL.

## ✅ Mises à jour récentes

### 🖨️ Option d'impression améliorée
- **Bouton "Imprimer la quittance"** sur chaque page de quittance
- **Bouton "Ouvrir pour impression"** pour afficher dans un nouvel onglet optimisé
- **Impression directe** depuis la liste des paiements et quittances
- Format professionnel avec signatures et cachet

### 🔘 Interface utilisateur révisée
- **Tous les boutons fonctionnels** avec icônes et libellés clairs
- **Groupes de boutons** avec `role="group"` pour une meilleure accessibilité
- **Statistiques enrichies** sur les pages Locataires et Paiements
- **Filtres intégrés** directement dans l'en-tête de la page Propriétés
- **Navigation fluide** entre les pages

## ✨ Fonctionnalités

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
