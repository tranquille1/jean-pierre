<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

$pageTitle = 'Ajouter un paiement';
$pdo = getDBConnection();

// Récupérer tous les locataires
$locataires = $pdo->query("SELECT id, nom, prenom FROM locataires ORDER BY nom, prenom")->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les propriétés pour le select (optionnel)
$proprietes = $pdo->query("SELECT id, titre, commune FROM proprietes ORDER BY titre")->fetchAll(PDO::FETCH_ASSOC);

if (isPost()) {
    $locataire_id = (int)$_POST['locataire_id'];
    $propriete_id = !empty($_POST['propriete_id']) ? (int)$_POST['propriete_id'] : null;
    $montant = (float)$_POST['montant'];
    $type_paiement = cleanInput($_POST['type_paiement']);
    $mode_paiement = cleanInput($_POST['mode_paiement']);
    $reference_transaction = cleanInput($_POST['reference_transaction']);
    $date_paiement = $_POST['date_paiement'];
    $date_echeance = !empty($_POST['date_echeance']) ? $_POST['date_echeance'] : null;
    $notes = cleanInput($_POST['notes']);
    

    if ($locataire_id && $montant > 0 && $type_paiement && $mode_paiement && $date_paiement) {
        $stmt = $pdo->prepare("
            INSERT INTO paiements (locataire_id, propriete_id, montant, type_paiement, mode_paiement, reference_transaction, date_paiement, date_echeance, notes)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $locataire_id, $propriete_id, $montant, $type_paiement, $mode_paiement, $reference_transaction, $date_paiement, $date_echeance, $notes
        ]);

        // Récupérer l'ID du paiement inséré
        $paiement_id = $pdo->lastInsertId();

        // Générer la quittance avec token et QR Code
        require_once 'includes/functions.php';
        $token = generateToken();
        $numero_quittance = 'QTC-' . date('Ymd') . '-' . str_pad($paiement_id, 4, '0', STR_PAD_LEFT);

        $stmtQuittance = $pdo->prepare("INSERT INTO quittances (paiement_id, numero_quittance, token_verification) VALUES (?, ?, ?)");
        $stmtQuittance->execute([$paiement_id, $numero_quittance, $token]);

        redirect('paiements.php');
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
                <i class="bi bi-plus-circle"></i> Nouveau paiement
            </div>
            <div class="card-body">
                <?php if (isset($message)): ?>
                <div class="alert alert-<?= $messageType ?>"><?= $message ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="locataire_id" class="form-label">Locataire *</label>
                            <select class="form-select" id="locataire_id" name="locataire_id" required>
                                <option value="">Choisir un locataire...</option>
                                <?php foreach ($locataires as $loc): ?>
                                <option value="<?= $loc['id'] ?>">
                                    <?= htmlspecialchars($loc['nom'] . ' ' . $loc['prenom']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="propriete_id" class="form-label">Propriété (optionnel)</label>
                            <select class="form-select" id="propriete_id" name="propriete_id">
                                <option value="">-- Aucune --</option>
                                <?php foreach ($proprietes as $prop): ?>
                                <option value="<?= $prop['id'] ?>">
                                    <?= htmlspecialchars($prop['titre']) ?> - <?= htmlspecialchars($prop['commune']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="col-md-4">
                            <label for="montant" class="form-label">Montant (FCFA) *</label>
                            <input type="number" class="form-control" id="montant" name="montant" required min="1000">
                        </div>
                        
                        <div class="col-md-4">
                            <label for="type_paiement" class="form-label">Type de paiement *</label>
                            <select class="form-select" id="type_paiement" name="type_paiement" required>
                                <option value="">Choisir...</option>
                                <?php foreach ($GLOBALS['types_paiement'] as $t): ?>
                                <option value="<?= $t ?>"><?= $t ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="col-md-4">
                            <label for="mode_paiement" class="form-label">Mode de paiement *</label>
                            <select class="form-select" id="mode_paiement" name="mode_paiement" required>
                                <option value="">Choisir...</option>
                                <?php foreach (array_keys($GLOBALS['modes_paiement']) as $m): ?>
                                <option value="<?= $m ?>"><?= $m ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="reference_transaction" class="form-label">Référence transaction</label>
                            <input type="text" class="form-control" id="reference_transaction" name="reference_transaction" 
                                   placeholder="Ex: OM123456789 (pour Mobile Money)">
                            <small class="text-muted">ID de transaction Orange Money, MTN MoMo ou Wave</small>
                        </div>
                        
                        <div class="col-md-3">
                            <label for="date_paiement" class="form-label">Date de paiement *</label>
                            <input type="date" class="form-control" id="date_paiement" name="date_paiement" 
                                   value="<?= date('Y-m-d') ?>" required>
                        </div>
                        
                        <div class="col-md-3">
                            <label for="date_echeance" class="form-label">Date d'échéance</label>
                            <input type="date" class="form-control" id="date_echeance" name="date_echeance">
                        </div>
                        
                        <div class="col-12">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="2" 
                                      placeholder="Informations complémentaires..."></textarea>
                        </div>
                    </div>
                    
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-ci">
                            <i class="bi bi-check-circle"></i> Enregistrer le paiement
                        </button>
                        <a href="paiements.php" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Mettre à jour dynamiquement la référence selon le mode de paiement
document.getElementById('mode_paiement').addEventListener('change', function() {
    const mode = this.value;
    const refLabel = document.querySelector('label[for="reference_transaction"]');
    const refInput = document.getElementById('reference_transaction');
    
    if (mode === 'Orange Money') {
        refInput.placeholder = 'Ex: OM' + Date.now();
    } else if (mode === 'MTN MoMo') {
        refInput.placeholder = 'Ex: MTN' + Date.now();
    } else if (mode === 'Wave') {
        refInput.placeholder = 'Ex: WV' + Date.now();
    } else {
        refInput.placeholder = '';
    }
});
</script>

<?php
$content = ob_get_clean();
include 'templates/layout.php';
?>
