<?php
/**
 * Page de vérification des quittances avec QR Code
 * CI Immobilier - Gestion Immobilière Ivoirienne
 */
require_once 'config/database.php';
require_once 'includes/functions.php';

$pdo = getDBConnection();

// Récupérer les paramètres
$quittance_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$token = isset($_GET['token']) ? cleanInput($_GET['token']) : '';

$quittance = null;
$valid = false;
$message = '';

if ($quittance_id > 0 && !empty($token)) {
    $stmt = $pdo->prepare("
        SELECT q.*, p.montant, p.type_paiement, p.mode_paiement, p.reference_transaction, 
               p.date_paiement, p.notes,
               l.nom, l.prenom, l.cni, l.telephone, l.email,
               pr.titre as propriete_titre, pr.commune, pr.adresse
        FROM quittances q
        JOIN paiements p ON q.paiement_id = p.id
        JOIN locataires l ON p.locataire_id = l.id
        LEFT JOIN proprietes pr ON p.propriete_id = pr.id
        WHERE q.id = ? AND q.token_verification = ?
    ");
    $stmt->execute([$quittance_id, $token]);
    $quittance = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($quittance) {
        $valid = true;
        // Marquer comme vérifiée si ce n'est pas déjà fait
        if (!$quittance['verified']) {
            $updateStmt = $pdo->prepare("UPDATE quittances SET verified = TRUE WHERE id = ?");
            $updateStmt->execute([$quittance_id]);
        }
    } else {
        $message = "Quittance invalide ou lien expiré. Veuillez vérifier le QR Code ou contacter l\'agence.';
    }
} else {
    $message = "Paramètres de vérification manquants.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification de Quittance - CI Immobilier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh; }
        .verification-card { max-width: 700px; margin: 40px auto; }
        .header-ci { background: linear-gradient(90deg, #FF8200 0%, #ffffff 50%, #00A650 100%); padding: 20px; border-radius: 10px 10px 0 0; }
        .valid-badge { background: #00A650; color: white; padding: 10px 20px; border-radius: 20px; font-weight: bold; }
        .invalid-badge { background: #dc3545; color: white; padding: 10px 20px; border-radius: 20px; font-weight: bold; }
        .info-row { padding: 10px 0; border-bottom: 1px solid #eee; }
        .info-label { font-weight: 600; color: #666; }
        .qr-section { text-align: center; padding: 20px; background: #f8f9fa; border-radius: 10px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="verification-card card shadow">
            <div class="header-ci text-center">
                <h1 class="text-dark mb-0"><i class="bi bi-shield-check"></i> Vérification de Quittance</h1>
                <p class="text-dark mb-0">CI Immobilier - République de Côte d'Ivoire</p>
            </div>
            
            <div class="card-body p-4">
                <?php if ($valid && $quittance): ?>
                    <div class="text-center mb-4">
                        <span class="valid-badge">
                            <i class="bi bi-check-circle-fill"></i> QUITTANCE AUTHENTIQUE
                        </span>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-success mb-3"><i class="bi bi-receipt"></i> Informations Quittance</h5>
                            <div class="info-row">
                                <span class="info-label">Numéro:</span> <?= htmlspecialchars($quittance['numero_quittance']) ?>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Date:</span> <?= formatDateFr($quittance['date_generation']) ?>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Montant:</span> <strong><?= formatFCFA($quittance['montant']) ?></strong>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Type:</span> <?= htmlspecialchars($quittance['type_paiement']) ?>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Mode de paiement:</span> 
                                <span style="color: <?= getModePaiementColor($quittance['mode_paiement']) ?>; font-weight: bold;">
                                    <i class="bi bi-circle-fill" style="font-size: 8px;"></i> <?= htmlspecialchars($quittance['mode_paiement']) ?>
                                </span>
                            </div>
                            <?php if ($quittance['reference_transaction']): ?>
                            <div class="info-row">
                                <span class="info-label">Référence:</span> <?= htmlspecialchars($quittance['reference_transaction']) ?>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6">
                            <h5 class="text-primary mb-3"><i class="bi bi-person"></i> Locataire</h5>
                            <div class="info-row">
                                <span class="info-label">Nom:</span> <?= htmlspecialchars($quittance['nom'] . ' ' . $quittance['prenom']) ?>
                            </div>
                            <?php if ($quittance['cni']): ?>
                            <div class="info-row">
                                <span class="info-label">CNI:</span> <?= htmlspecialchars($quittance['cni']) ?>
                            </div>
                            <?php endif; ?>
                            <div class="info-row">
                                <span class="info-label">Téléphone:</span> <?= formatTelephone($quittance['telephone']) ?>
                            </div>
                            <?php if ($quittance['propriete_titre']): ?>
                            <hr>
                            <h5 class="text-info mb-3"><i class="bi bi-house"></i> Propriété</h5>
                            <div class="info-row">
                                <span class="info-label">Titre:</span> <?= htmlspecialchars($quittance['propriete_titre']) ?>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Commune:</span> <?= htmlspecialchars($quittance['commune']) ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="qr-section">
                        <img src="<?= getQRCodeUrl($quittance['numero_quittance'] . '|' . $quittance['token_verification']) ?>" 
                             alt="QR Code de vérification" class="img-fluid" style="max-width: 200px;">
                        <p class="mt-2 text-muted small">Scannez ce QR Code pour vérifier cette quittance</p>
                    </div>

                    <div class="text-center mt-4">
                        <a href="index.php" class="btn btn-ci">
                            <i class="bi bi-house"></i> Retour à l'accueil
                        </a>
                    </div>

                <?php else: ?>
                    <div class="text-center mb-4">
                        <span class="invalid-badge">
                            <i class="bi bi-x-circle-fill"></i> QUITTANCE INVALIDE
                        </span>
                    </div>
                    
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <strong>Attention!</strong> <?= htmlspecialchars($message) ?>
                    </div>

                    <div class="text-center mt-4">
                        <a href="index.php" class="btn btn-outline-primary">
                            <i class="bi bi-house"></i> Retour à l'accueil
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <div class="card-footer text-center text-muted small">
                <p class="mb-0">© <?= date('Y') ?> CI Immobilier - Système de vérification sécurisé</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
