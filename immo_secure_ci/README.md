# 🏠 ImmoSecure CI - Application Immobilière Sécurisée

Application mobile React Native/Expo pour le marché immobilier ivoirien, conçue pour lutter contre les arnaques et simplifier l'accès au logement.

## 🎯 Objectifs

- **Simple** : Utilisable par tous, même les non-tech
- **Fiable** : Inspire confiance immédiatement
- **Rapide** : Accès aux biens en 2-3 clics

## 🚀 Fonctionnalités principales

### 1. Page d'accueil (Home)
- Barre de recherche centrale
- Localisation automatique (Abidjan par défaut)
- Filtres rapides : Location, Achat, Terrain
- Sections : Biens recommandés, Biens certifiés, Biens proches

### 2. Recherche avancée
- Filtres par prix, zone, type, nombre de pièces
- Toggle "Certifié uniquement"
- Affichage liste/carte

### 3. Détail d'un bien
- Carousel d'images
- Badge de vérification
- Score de sécurité (0-100)
- Documents disponibles
- Informations propriétaire
- Actions : Contacter, Appeler, Réserver visite

### 4. Module Sécurité (Innovation)
- Score de confiance 0-100
- Couleurs : Vert (sûr), Orange (moyen), Rouge (risqué)
- Documents validés, identité vérifiée, historique

### 5. Messagerie intégrée
- Chat direct avec propriétaires
- Envoi d'images/documents
- Historique des conversations

### 6. Profil utilisateur
- Informations personnelles
- Statut vérifié
- Mes biens, favoris, messages

## 📁 Structure du projet

```
immo_secure_ci/
├── src/
│   ├── components/
│   │   ├── PropertyCard.js       # Carte de bien immobilier
│   │   ├── SecurityBadge.js      # Badge de sécurité
│   │   └── SearchBar.js          # Barre de recherche
│   ├── screens/
│   │   ├── HomeScreen.js         # Page d'accueil
│   │   ├── SearchScreen.js       # Recherche avancée
│   │   ├── PropertyDetailScreen.js # Détail du bien
│   │   ├── ChatScreen.js         # Messagerie
│   │   └── ProfileScreen.js      # Profil utilisateur
│   ├── navigation/
│   │   └── AppNavigator.js       # Configuration navigation
│   ├── utils/
│   │   └── theme.js              # Design system (couleurs, styles)
│   ├── data/
│   │   └── mockData.js           # Données factices
│   └── App.js                    # Point d'entrée
├── app.json                      # Configuration Expo
├── babel.config.js               # Configuration Babel
└── package.json                  # Dépendances
```

## 🎨 Design System

### Couleurs
- **Bleu** (#2563EB) : Confiance
- **Vert** (#10B981) : Sécurité/Vérifié
- **Orange** (#F59E0B) : Moyen/Attention
- **Rouge** (#EF4444) : Risqué/Non vérifié

### Typographie
- Police : Poppins, Roboto
- Style : Minimaliste et lisible

## 🛠️ Installation

```bash
# Installer les dépendances
cd immo_secure_ci
npm install

# Démarrer l'application
npm start

# Lancer sur Android
npm run android

# Lancer sur iOS
npm run ios
```

## 📱 Parcours utilisateur type

1. Ouvre l'application
2. Recherche un logement
3. Filtre "certifié"
4. Consulte les détails
5. Vérifie le score de sécurité
6. Contacte le propriétaire via chat
7. Réserve une visite

## 🔐 Innovation Sécurité

Le module de sécurité est au cœur de l'application :
- Vérification des documents (ACD, titre foncier, permis)
- Validation d'identité des propriétaires
- Score de confiance calculé automatiquement
- Historique des transactions

## 🚀 Roadmap

### Phase 1 (Actuelle)
- ✅ Marketplace simple
- ✅ Vérification basique
- ✅ Navigation entre écrans

### Phase 2
- [ ] Système juridique complet
- [ ] Paiement sécurisé (Mobile Money)
- [ ] Upload de documents

### Phase 3
- [ ] Financement immobilier
- [ ] IA de détection de fraude
- [ ] Scoring avancé

### Phase 4
- [ ] Extension Afrique de l'Ouest
- [ ] Blockchain foncière
- [ ] Tribunal digital

## 📊 Contexte marché ivoirien

- Déficit de 600 000 logements (400 000 à Abidjan)
- 69% de locataires
- Problèmes fonciers majeurs (double vente, faux papiers)
- Marché peu digitalisé

## 💡 Opportunités

- Créer le "Jumia immobilier sécurisé ivoirien"
- Digitaliser les transactions
- Lutter contre les arnaques
- Faciliter l'accès au financement

## 👥 Équipe & Technologies

- **Frontend** : React Native / Expo
- **Navigation** : React Navigation
- **UI** : Composants natifs personnalisés
- **Backend** (à venir) : Node.js / Django
- **Base de données** (à venir) : PostgreSQL / MongoDB

## 📄 License

MIT License - Voir LICENSE pour plus de détails

---

**ImmoSecure CI** © 2024 - Côte d'Ivoire 🇨🇮
