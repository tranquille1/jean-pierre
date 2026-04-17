<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

$pageTitle = 'Ajouter un locataire';
$pdo = getDBConnection();

// Récupérer les propriétés disponibles pour le select
$proprietesDisponibles = $pdo->query("SELECT id, titre, commune FROM proprietes WHERE statut = 'Disponible' ORDER BY titre")->fetchAll(PDO::FETCH_ASSOC);

if (isPost()) {
    $nom = cleanInput($_POST['nom']);
    $prenom = cleanInput($_POST['prenom']);
    $cni = cleanInput($_POST['cni']);
    $telephone = cleanInput($_POST['telephone']);
    $email = cleanInput($_POST['email']);
    $profession = cleanInput($_POST['profession']);
    $adresse_complet = cleanInput($_POST['adresse_complet']);
    $date_entree = !empty($_POST['date_entree']) ? $_POST['date_entree'] : null;
    $propriete_id = !empty($_POST['propriete_id']) ? (int)$_POST['propriete_id'] : null;
    
    if ($nom && $prenom) {
        $stmt = $pdo->prepare("
            INSERT INTO locataires (nom, prenom, cni, telephone, email, profession, adresse_complet, date_entree, propriete_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $nom, $prenom, $cni, $telephone, $email, $profession, $adresse_complet, $date_entree, $propriete_id
        ]);
        
        // Mettre à jour le statut de la propriété si une propriété a été assignée
        if ($propriete_id) {
            $pdo->prepare("UPDATE proprietes SET statut = 'Loué' WHERE id = ?")->execute([$propriete_id]);
        }
        
        redirect('locataires.php');
    } else {
        $message = "Veuillez remplir au moins le nom et le prénom";
        $messageType = 'danger';
    }
}

ob_start();
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-person-plus"></i> Nouveau locataire
            </div>
            <div class="card-body">
                <?php if (isset($message)): ?>
                <div class="alert alert-<?= $messageType ?>"><?= $message ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nom" class="form-label">Nom *</label>
                            <input type="text" class="form-control" id="nom" name="nom" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="prenom" class="form-label">Prénom *</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="cni" class="form-label">Numéro CNI</label>
                            <input type="text" class="form-control" id="cni" name="cni" 
                                   placeholder="Ex: 1234567A123456">
                            <small class="text-muted">Carte Nationale d'Identité ivoirienne</small>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="telephone" class="form-label">Téléphone</label>
                            <input type="tel" class="form-control" id="telephone" name="telephone" 
                                   placeholder="07 XX XX XX XX">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="profession" class="form-label">Profession</label>
                            <input type="text" class="form-control" id="profession" name="profession">
                        </div>
                        
                        <div class="col-12">
                            <label for="adresse_complet" class="form-label">Adresse complète</label>
                            <textarea class="form-control" id="adresse_complet" name="adresse_complet" rows="2"></textarea>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="date_entree" class="form-label">Date d'entrée</label>
                            <input type="date" class="form-control" id="date_entree" name="date_entree">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="propriete_id" class="form-label">Propriété à louer</label>
                            <select class="form-select" id="propriete_id" name="propriete_id">
                                <option value="">-- Aucune --</option>
                                <?php foreach ($proprietesDisponibles as $prop): ?>
                                <option value="<?= $prop['id'] ?>">
                                    <?= htmlspecialchars($prop['titre']) ?> - <?= htmlspecialchars($prop['commune']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted">La propriété passera automatiquement en statut "Loué"</small>
                        </div>
                    </div>
                    
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-ci">
                            <i class="bi bi-check-circle"></i> Enregistrer
                        </button>
                        <a href="locataires.php" class="btn btn-outline-secondary">
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
