<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

$pageTitle = 'Ajouter une propriété';
$pdo = getDBConnection();
$message = null;
$messageType = 'info';

if (isPost()) {
    $titre = cleanInput($_POST['titre']);
    $type = cleanInput($_POST['type']);
    $commune = cleanInput($_POST['commune']);
    $adresse = cleanInput($_POST['adresse']);
    $nb_pieces = !empty($_POST['nb_pieces']) ? (int)$_POST['nb_pieces'] : null;
    $superficie = !empty($_POST['superficie']) ? (float)$_POST['superficie'] : null;
    $prix_loyer = (float)$_POST['prix_loyer'];
    $statut = $_POST['statut'];
    $proprietaire_nom = cleanInput($_POST['proprietaire_nom']);
    $proprietaire_telephone = cleanInput($_POST['proprietaire_telephone']);
    
    if ($titre && $type && $commune && $prix_loyer) {
        $stmt = $pdo->prepare("
            INSERT INTO proprietes (titre, type, commune, adresse, nb_pieces, superficie, prix_loyer, statut, proprietaire_nom, proprietaire_telephone)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $titre, $type, $commune, $adresse, $nb_pieces, $superficie, $prix_loyer, $statut, $proprietaire_nom, $proprietaire_telephone
        ]);
        
        redirect('proprietes.php');
    } else {
        $message = "Veuillez remplir les champs obligatoires";
        $messageType = 'danger';
    }
}

ob_start();
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-plus-circle"></i> Ajouter une nouvelle propriété
            </div>
            <div class="card-body">
                <?php if ($message): ?>
                <div class="alert alert-<?= $messageType ?>"><?= $message ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label for="titre" class="form-label">Titre *</label>
                            <input type="text" class="form-control" id="titre" name="titre" required 
                                   placeholder="Ex: Appartement 2 pièces Cocody">
                        </div>
                        
                        <div class="col-md-4">
                            <label for="type" class="form-label">Type *</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="">Choisir...</option>
                                <?php foreach ($GLOBALS['types_logement'] as $t): ?>
                                <option value="<?= $t ?>"><?= $t ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="commune" class="form-label">Commune *</label>
                            <select class="form-select" id="commune" name="commune" required>
                                <option value="">Choisir...</option>
                                <?php foreach ($GLOBALS['communes'] as $c): ?>
                                <option value="<?= $c ?>"><?= $c ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="statut" class="form-label">Statut</label>
                            <select class="form-select" id="statut" name="statut">
                                <option value="Disponible">Disponible</option>
                                <option value="Loué">Loué</option>
                            </select>
                        </div>
                        
                        <div class="col-12">
                            <label for="adresse" class="form-label">Adresse complète</label>
                            <textarea class="form-control" id="adresse" name="adresse" rows="2" 
                                      placeholder="Quartier, rue, points de repère..."></textarea>
                        </div>
                        
                        <div class="col-md-4">
                            <label for="nb_pieces" class="form-label">Nombre de pièces</label>
                            <input type="number" class="form-control" id="nb_pieces" name="nb_pieces" min="1">
                        </div>
                        
                        <div class="col-md-4">
                            <label for="superficie" class="form-label">Superficie (m²)</label>
                            <input type="number" step="0.01" class="form-control" id="superficie" name="superficie" min="1">
                        </div>
                        
                        <div class="col-md-4">
                            <label for="prix_loyer" class="form-label">Prix du loyer (FCFA) *</label>
                            <input type="number" class="form-control" id="prix_loyer" name="prix_loyer" required min="10000">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="proprietaire_nom" class="form-label">Nom du propriétaire</label>
                            <input type="text" class="form-control" id="proprietaire_nom" name="proprietaire_nom">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="proprietaire_telephone" class="form-label">Téléphone propriétaire</label>
                            <input type="tel" class="form-control" id="proprietaire_telephone" name="proprietaire_telephone" 
                                   placeholder="07 XX XX XX XX">
                        </div>
                    </div>
                    
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-ci">
                            <i class="bi bi-check-circle"></i> Enregistrer
                        </button>
                        <a href="proprietes.php" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'templates/layout.php';
?>
