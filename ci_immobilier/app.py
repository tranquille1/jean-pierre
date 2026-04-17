"""
Application de Gestion Immobilière - Contexte Ivoirien
Gère les locations, paiements Mobile Money (Orange, MTN, Wave), et quittances.
"""

from flask import Flask, render_template, request, redirect, url_for, flash
from flask_sqlalchemy import SQLAlchemy
from datetime import datetime
import os

app = Flask(__name__)
app.config['SECRET_KEY'] = 'ci-immobilier-secret-key-2024'
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///ci_immobilier.db'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)

# Modèles de données
class Propriete(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    nom = db.Column(db.String(100), nullable=False)
    adresse = db.Column(db.String(200), nullable=False)
    commune = db.Column(db.String(50), nullable=False)  # Cocody, Yopougon, Plateau, etc.
    type_logement = db.Column(db.String(50), nullable=False)  # Appartement, Villa, Studio
    nb_pieces = db.Column(db.Integer, default=1)
    loyer_mensuel = db.Column(db.Float, nullable=False)
    disponible = db.Column(db.Boolean, default=True)
    proprietaire = db.Column(db.String(100), nullable=False)
    telephone_proprio = db.Column(db.String(20))
    
    def __repr__(self):
        return f'<Propriété {self.nom}>'

class Locataire(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    nom = db.Column(db.String(100), nullable=False)
    prenom = db.Column(db.String(100), nullable=False)
    telephone = db.Column(db.String(20), nullable=False)
    email = db.Column(db.String(100))
    cni_numero = db.Column(db.String(30))  # Numéro CNI ivoirienne
    profession = db.Column(db.String(100))
    date_entree = db.Column(db.DateTime, default=datetime.utcnow)
    propriete_id = db.Column(db.Integer, db.ForeignKey('propriete.id'))
    propriete = db.relationship('Propriete', backref=db.backref('locataires', lazy=True))
    
    def __repr__(self):
        return f'<Locataire {self.nom} {self.prenom}>'

class Paiement(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    locataire_id = db.Column(db.Integer, db.ForeignKey('locataire.id'), nullable=False)
    locataire = db.relationship('Locataire', backref=db.backref('paiements', lazy=True))
    montant = db.Column(db.Float, nullable=False)
    date_paiement = db.Column(db.DateTime, default=datetime.utcnow)
    mois_concerne = db.Column(db.String(20), nullable=False)  # Ex: "Janvier 2024"
    mode_paiement = db.Column(db.String(50), nullable=False)  # Orange Money, MTN MoMo, Wave, Espèces, Chèque
    reference_transaction = db.Column(db.String(100))  # ID transaction Mobile Money
    type_paiement = db.Column(db.String(50), default='Loyer')  # Loyer, Caution, Électricité, Eau
    statut = db.Column(db.String(20), default='Validé')  # Validé, En attente, Rejeté
    notes = db.Column(db.Text)
    
    def __repr__(self):
        return f'<Paiement {self.montant} FCFA - {self.mode_paiement}>'

class Quittance(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    paiement_id = db.Column(db.Integer, db.ForeignKey('paiement.id'), nullable=False)
    paiement = db.relationship('Paiement', backref=db.backref('quittance', lazy=True))
    numero_quittance = db.Column(db.String(50), unique=True, nullable=False)
    date_emission = db.Column(db.DateTime, default=datetime.utcnow)
    
    def __repr__(self):
        return f'<Quittance {self.numero_quittance}>'

# Initialisation de la base de données
with app.app_context():
    db.create_all()

# Routes
@app.route('/')
def index():
    proprietes = Propriete.query.all()
    locataires = Locataire.query.all()
    paiements = Paiement.query.order_by(Paiement.date_paiement.desc()).limit(10).all()
    return render_template('index.html', proprietes=proprietes, locataires=locataires, paiements=paiements)

@app.route('/proprietes')
def liste_proprietes():
    proprietes = Propriete.query.all()
    return render_template('proprietes.html', proprietes=proprietes)

@app.route('/propriete/ajouter', methods=['GET', 'POST'])
def ajouter_propriete():
    if request.method == 'POST':
        propriete = Propriete(
            nom=request.form['nom'],
            adresse=request.form['adresse'],
            commune=request.form['commune'],
            type_logement=request.form['type_logement'],
            nb_pieces=int(request.form.get('nb_pieces', 1)),
            loyer_mensuel=float(request.form['loyer_mensuel']),
            disponible=request.form.get('disponible') == 'on',
            proprietaire=request.form['proprietaire'],
            telephone_proprio=request.form.get('telephone_proprio')
        )
        db.session.add(propriete)
        db.session.commit()
        flash('Propriété ajoutée avec succès !', 'success')
        return redirect(url_for('liste_proprietes'))
    return render_template('ajouter_propriete.html')

@app.route('/locataires')
def liste_locataires():
    locataires = Locataire.query.all()
    return render_template('locataires.html', locataires=locataires)

@app.route('/locataire/ajouter', methods=['GET', 'POST'])
def ajouter_locataire():
    if request.method == 'POST':
        locataire = Locataire(
            nom=request.form['nom'],
            prenom=request.form['prenom'],
            telephone=request.form['telephone'],
            email=request.form.get('email'),
            cni_numero=request.form.get('cni_numero'),
            profession=request.form.get('profession'),
            propriete_id=int(request.form['propriete_id']) if request.form.get('propriete_id') else None
        )
        db.session.add(locataire)
        db.session.commit()
        flash('Locataire ajouté avec succès !', 'success')
        return redirect(url_for('liste_locataires'))
    proprietes = Propriete.query.filter_by(disponible=True).all()
    return render_template('ajouter_locataire.html', proprietes=proprietes)

@app.route('/paiements')
def liste_paiements():
    paiements = Paiement.query.order_by(Paiement.date_paiement.desc()).all()
    return render_template('paiements.html', paiements=paiements)

@app.route('/paiement/ajouter', methods=['GET', 'POST'])
def ajouter_paiement():
    if request.method == 'POST':
        paiement = Paiement(
            locataire_id=int(request.form['locataire_id']),
            montant=float(request.form['montant']),
            mois_concerne=request.form['mois_concerne'],
            mode_paiement=request.form['mode_paiement'],
            reference_transaction=request.form.get('reference_transaction'),
            type_paiement=request.form.get('type_paiement', 'Loyer'),
            notes=request.form.get('notes')
        )
        db.session.add(paiement)
        db.session.commit()
        
        # Générer une quittance automatique
        numero_quittance = f"QTC-{datetime.now().strftime('%Y%m%d')}-{paiement.id}"
        quittance = Quittance(paiement_id=paiement.id, numero_quittance=numero_quittance)
        db.session.add(quittance)
        db.session.commit()
        
        flash(f'Paiement enregistré ! Quittance générée : {numero_quittance}', 'success')
        return redirect(url_for('liste_paiements'))
    locataires = Locataire.query.all()
    return render_template('ajouter_paiement.html', locataires=locataires)

@app.route('/quittances')
def liste_quittances():
    quittances = Quittance.query.order_by(Quittance.date_emission.desc()).all()
    return render_template('quittances.html', quittances=quittances)

@app.route('/quittance/<int:id>')
def voir_quittance(id):
    quittance = Quittance.query.get_or_404(id)
    return render_template('quittance_detail.html', quittance=quittance)

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=5000)
