# 🏠 CI Immobilier - Application de Gestion Immobilière

Application de gestion immobilière spécialement conçue pour le contexte ivoirien.

## ✨ Fonctionnalités

### 🏘️ Gestion des Propriétés
- Enregistrement des propriétés avec localisation par commune (Cocody, Yopougon, Plateau, etc.)
- Types de logements : Studio, Appartement, Villa, Duplex, Chambre, Local commercial
- Suivi du statut (Disponible/Loué)
- Informations propriétaire

### 👥 Gestion des Locataires
- Profil complet avec CNI ivoirienne
- Coordonnées complètes (téléphone, email, profession)
- Historique des locations
- Date d'entrée

### 💰 Gestion des Paiements
**Modes de paiement adaptés au marché ivoirien :**
- 🟠 Orange Money
- 💛 MTN MoMo
- 💙 Wave
- 💵 Espèces
- 📝 Chèque
- 🏦 Virement bancaire

**Types de paiement :**
- Loyer
- Caution
- Électricité (CIE)
- Eau (SODECI)
- Frais d'entretien
- Autre

### 📄 Génération de Quittances
- Quittances automatiques avec numéro unique
- Format professionnel imprimable
- Détails complets du paiement
- Référence de transaction Mobile Money

## 🚀 Installation

```bash
# Installer les dépendances
pip install -r requirements.txt

# Lancer l'application
python app.py
```

L'application sera accessible à : http://localhost:5000

## 📁 Structure du projet

```
ci_immobilier/
├── app.py                 # Application principale Flask
├── requirements.txt       # Dépendances Python
├── templates/             # Templates HTML
│   ├── base.html         # Template de base
│   ├── index.html        # Tableau de bord
│   ├── proprietes.html   # Liste des propriétés
│   ├── ajouter_propriete.html
│   ├── locataires.html   # Liste des locataires
│   ├── ajouter_locataire.html
│   ├── paiements.html    # Liste des paiements
│   ├── ajouter_paiement.html
│   ├── quittances.html   # Liste des quittances
│   └── quittance_detail.html
└── static/               # Fichiers statiques (CSS, JS, images)
```

## 💡 Cas d'usage ivoiriens

- **Gestion par commune** : Toutes les communes d'Abidjan sont pré-enregistrées
- **Mobile Money** : Support natif des transactions Orange Money, MTN MoMo et Wave
- **CNI** : Champ dédié pour la Carte Nationale d'Identité
- **Factures CIE/SODECI** : Types de paiement spécifiques pour électricité et eau
- **Quittances** : Format adapté aux exigences locales

## 🎨 Design

Interface moderne et responsive avec :
- Couleurs inspirées du drapeau ivoirien (Orange, Blanc, Vert)
- Navigation intuitive
- Tableaux clairs et lisibles
- Badges colorés pour les modes de paiement

## 📝 Base de données

SQLite est utilisé par défaut. La base de données est créée automatiquement au premier lancement.

Fichier : `instance/ci_immobilier.db`

## 🔐 Sécurité

- Clé secrète configurée pour les sessions Flask
- Validation des formulaires côté serveur
- Protection CSRF (à activer en production)

## 🌍 Adapté au contexte ivoirien

Cette application prend en compte les spécificités du marché immobilier ivoirien :
- Utilisation massive du Mobile Money
- Importance de la CNI dans les transactions
- Gestion des factures CIE et SODECI
- Organisation par communes d'Abidjan
- Formats de quittances conformes aux usages locaux

## 📞 Support

Pour toute question ou amélioration, n'hésitez pas à contribuer !

---

Fait avec ❤️ pour la Côte d'Ivoire 🇨🇮
