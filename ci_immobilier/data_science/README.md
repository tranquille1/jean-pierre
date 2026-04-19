# 🏠 Projet Data Science - CI Immobilier

## 📚 Notebook Pédagogique Complet

Ce dossier contient un projet complet de data science appliqué à la gestion immobilière ivoirienne.

---

## 📁 Fichiers disponibles

| Fichier | Description |
|---------|-------------|
| `01_projet_complet_data_science.ipynb` | Notebook Jupyter avec toutes les étapes du projet |
| `proprietes.csv` | Dataset des propriétés (200 lignes) |
| `locataires.csv` | Dataset des locataires (150 lignes) |
| `paiements.csv` | Dataset des paiements (500 lignes) |

---

## 🎯 Ce que vous allez apprendre

### 1. **📊 Exploration et Nettoyage des Données (EDA)**
- Charger et inspecter des datasets
- Identifier les valeurs manquantes
- Calculer les statistiques descriptives

### 2. **📈 Visualisation et Analyse Descriptive**
- Créer des histogrammes, boxplots, heatmaps
- Analyser les distributions et corrélations
- Utiliser matplotlib et seaborn

### 3. **🏠 Analyse des Prix par Commune et Type de Logement**
- Agrégation et pivot tables
- Analyse comparative
- Visualisations avancées

### 4. **💰 Prédiction des Loyers (Machine Learning - Régression)**
- Préparer les données (encodage, split train/test)
- Entraîner plusieurs modèles (Linear Regression, Random Forest, Gradient Boosting, etc.)
- Évaluer avec RMSE, MAE, R²
- Analyser l'importance des features

### 5. **📉 Détection d'Anomalies dans les Paiements**
- Méthodes statistiques (IQR)
- Isolation Forest (Machine Learning non-supervisé)
- Visualisation des anomalies

### 6. **🎯 Segmentation des Locataires (Clustering)**
- K-Means pour la segmentation
- Méthode du coude pour déterminer le nombre optimal de clusters
- PCA pour la visualisation
- Interprétation business des segments

### 7. **📊 Dashboard et Conclusions**
- Synthétiser les insights
- Présenter les résultats aux stakeholders
- Recommandations actionnables

---

## 🚀 Comment utiliser ce notebook

### Option 1: Jupyter Notebook (Recommandé)
```bash
# Installer Jupyter si nécessaire
pip install jupyter

# Lancer Jupyter
cd /workspace/ci_immobilier/data_science
jupyter notebook
```

### Option 2: Google Colab
1. Allez sur [Google Colab](https://colab.research.google.com/)
2. Uploader le fichier `01_projet_complet_data_science.ipynb`
3. Exécuter cellule par cellule

### Option 3: VS Code
1. Ouvrir VS Code
2. Installer l'extension "Jupyter"
3. Ouvrir le notebook et exécuter

---

## 📋 Prérequis

### Bibliothèques Python nécessaires
```bash
pip install pandas numpy matplotlib seaborn scikit-learn jupyter
```

### Versions testées
- Python: 3.8+
- pandas: 2.0+
- numpy: 1.20+
- scikit-learn: 1.0+
- matplotlib: 3.5+
- seaborn: 0.11+

---

## 📊 Structure du Projet

```
data_science/
├── 01_projet_complet_data_science.ipynb  # Notebook principal
├── proprietes.csv                         # Données propriétés
├── locataires.csv                         # Données locataires
├── paiements.csv                          # Données paiements
└── README.md                              # Ce fichier
```

---

## 🎓 Concepts Clés Enseignés

### Machine Learning Supervisé
- **Régression Linéaire**: Prédire les prix basés sur les features
- **Random Forest**: Modèle ensemble pour meilleure précision
- **Gradient Boosting**: Optimisation séquentielle des erreurs

### Machine Learning Non-Supervisé
- **K-Means**: Segmentation des locataires
- **Isolation Forest**: Détection d'anomalies
- **PCA**: Réduction de dimension pour visualisation

### Statistiques
- **Distribution**: Comprendre la répartition des données
- **Corrélation**: Relations entre variables
- **IQR**: Détection statistique d'anomalies

### Visualisation
- **Histogrammes**: Distribution d'une variable
- **Boxplots**: Quartiles et outliers
- **Heatmaps**: Corrélations et matrices
- **Scatter plots**: Relations entre deux variables

---

## 💡 Conseils pour Apprendre

1. **Exécutez cellule par cellule**: Ne passez pas à la suite sans comprendre
2. **Modifiez les paramètres**: Changez les hyperparamètres et observez les effets
3. **Posez-vous des questions**: Pourquoi ce modèle est meilleur ? Que signifie ce coefficient ?
4. **Expérimentez**: Ajoutez vos propres analyses, testez d'autres approches
5. **Prenez des notes**: Notez les concepts clés et les commandes importantes

---

## 🔍 Insights Attendus

Après avoir complété ce notebook, vous devriez être capable de répondre à :

- ✅ Quelle commune a les loyers les plus chers ?
- ✅ Quel type de logement est le plus rentable ?
- ✅ Peut-on prédire le prix d'un logement avec précision ?
- ✅ Quels sont les paiements suspects/anormaux ?
- ✅ Comment segmenter les locataires pour un marketing ciblé ?
- ✅ Quelles variables influencent le plus les prix ?

---

## 📚 Ressources Complémentaires

### Documentation Officielle
- [pandas](https://pandas.pydata.org/docs/)
- [scikit-learn](https://scikit-learn.org/stable/)
- [matplotlib](https://matplotlib.org/stable/contents.html)
- [seaborn](https://seaborn.pydata.org/tutorial.html)

### Cours en Ligne
- Coursera: Machine Learning by Andrew Ng
- DataCamp: Data Scientist Track
- Kaggle Learn: Free micro-courses

### Livres Recommandés
- "Python for Data Analysis" by Wes McKinney
- "Hands-On Machine Learning" by Aurélien Géron
- "Introduction to Statistical Learning" (ISL)

---

## 🎯 Prochaines Étapes

Après avoir maîtrisé ce notebook, vous pouvez :

1. **Améliorer le modèle**
   - Ajouter plus de features
   - Tester XGBoost, LightGBM
   - Faire du hyperparameter tuning avec GridSearchCV

2. **Time Series Forecasting**
   - Prédire les revenus futurs
   - Détecter les tendances saisonnières
   - Utiliser Prophet ou ARIMA

3. **Système de Recommandation**
   - Recommander des propriétés aux locataires
   - Filtrage collaboratif ou content-based

4. **Deployment**
   - Créer une API Flask/FastAPI
   - Intégrer dans l'application web
   - Dashboard interactif avec Streamlit

5. **Data Pipeline**
   - Automatiser l'extraction depuis la BDD MySQL
   - Mettre en place des rapports automatiques
   - Orchestration avec Apache Airflow

---

## ❓ Besoin d'Aide ?

N'hésitez pas à :
- Relire les sections qui ne sont pas claires
- Expérimenter avec le code
- Consulter la documentation officielle
- Poser des questions sur Stack Overflow ou Reddit (r/datascience)

---

## 📝 Licence

Ce projet pédagogique est fourni à des fins éducatives. Vous êtes libre de l'utiliser, le modifier et le partager.

---

**Bon courage dans votre apprentissage de la Data Science ! 🎉**

*Créé avec ❤️ pour la communauté data science ivoirienne*
