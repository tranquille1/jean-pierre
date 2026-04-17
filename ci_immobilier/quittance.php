<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$pdo = getDBConnection();

// Récupérer le paiement avec les détails
$stmt = $pdo->prepare("
    SELECT p.*, l.nom, l.prenom, l.cni, l.telephone, l.email, l.adresse_complet, 
           pr.titre as propriete_titre, pr.commune, pr.adresse as propriete_adresse, pr.type
    FROM paiements p
    JOIN locataires l ON p.locataire_id = l.id
    LEFT JOIN proprietes pr ON p.propriete_id = pr.id
    WHERE p.id = ?
");
$stmt->execute([$id]);
$paiement = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$paiement) {
    die("Paiement non trouvé");
}

$numeroQuittance = genererNumeroQuittance($paiement['id']);
$isPrint = isset($_GET['print']);

ob_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quittance <?= $numeroQuittance ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white; }
            .quittance { box-shadow: none !important; border: 2px solid #333 !important; }
        }
        
        .quittance {
            max-width: 800px;
            margin: 20px auto;
            background: white;
            padding: 40px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border: 1px solid #ddd;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #FF7900;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #333;
            font-size: 24px;
            margin: 0;
        }
        
        .header .subtitle {
            color: #666;
            font-size: 14px;
            margin-top: 5px;
        }
        
        .info-section {
            margin-bottom: 25px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px dashed #eee;
        }
        
        .info-label {
            font-weight: bold;
            color: #555;
        }
        
        .montant-box {
            background: linear-gradient(135deg, #FF7900, #00A65E);
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            margin: 20px 0;
        }
        
        .montant-box .label {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .montant-box .value {
            font-size: 32px;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #333;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            padding-top: 20px;
        }
        
        .signature-box {
            text-align: center;
            width: 45%;
        }
        
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 50px;
            padding-top: 5px;
        }
    </style>
</head>
<body class="<?= $isPrint ? '' : 'bg-light' ?>">
    <?php if (!$isPrint): ?>
    <div class="container no-print my-4">
        <a href="quittances.php" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
        <button onclick="window.print()" class="btn btn-success ms-2">
            <i class="bi bi-printer"></i> Imprimer
        </button>
    </div>
    <?php endif; ?>
    
    <div class="quittance">
        <div class="header">
            <h1>🇨🇮 CI IMMOBILIER</h1>
            <p class="subtitle">Gestion Immobilière - République de Côte d'Ivoire</p>
            <h2 style="color: #FF7900; margin-top: 15px;">QUITTANCE DE PAIEMENT</h2>
        </div>
        
        <div class="info-section">
            <div class="info-row">
                <span class="info-label">Numéro de quittance:</span>
                <strong><?= $numeroQuittance ?></strong>
            </div>
            <div class="info-row">
                <span class="info-label">Date d'émission:</span>
                <span><?= date('d/m/Y à H:i', strtotime($paiement['created_at'])) ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Date de paiement:</span>
                <span><?= date('d/m/Y', strtotime($paiement['date_paiement'])) ?></span>
            </div>
        </div>
        
        <div class="info-section">
            <h5 style="color: #FF7900; border-bottom: 2px solid #FF7900; padding-bottom: 5px;">LOCATAIRE</h5>
            <div class="info-row">
                <span class="info-label">Nom et prénom:</span>
                <span><?= htmlspecialchars($paiement['nom'] . ' ' . $paiement['prenom']) ?></span>
            </div>
            <?php if ($paiement['cni']): ?>
            <div class="info-row">
                <span class="info-label">CNI:</span>
                <span><?= htmlspecialchars($paiement['cni']) ?></span>
            </div>
            <?php endif; ?>
            <?php if ($paiement['telephone']): ?>
            <div class="info-row">
                <span class="info-label">Téléphone:</span>
                <span><?= formatTelephone($paiement['telephone']) ?></span>
            </div>
            <?php endif; ?>
            <?php if ($paiement['adresse_complet']): ?>
            <div class="info-row">
                <span class="info-label">Adresse:</span>
                <span><?= htmlspecialchars($paiement['adresse_complet']) ?></span>
            </div>
            <?php endif; ?>
        </div>
        
        <?php if ($paiement['propriete_titre']): ?>
        <div class="info-section">
            <h5 style="color: #00A65E; border-bottom: 2px solid #00A65E; padding-bottom: 5px;">PROPRIÉTÉ</h5>
            <div class="info-row">
                <span class="info-label">Désignation:</span>
                <span><?= htmlspecialchars($paiement['propriete_titre']) ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Type:</span>
                <span><?= htmlspecialchars($paiement['type']) ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Commune:</span>
                <span><?= htmlspecialchars($paiement['commune']) ?></span>
            </div>
            <?php if ($paiement['propriete_adresse']): ?>
            <div class="info-row">
                <span class="info-label">Adresse:</span>
                <span><?= htmlspecialchars($paiement['propriete_adresse']) ?></span>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <div class="montant-box">
            <div class="label">MONTANT PAYÉ</div>
            <div class="value"><?= formatFCFA($paiement['montant']) ?></div>
            <div class="label">
                <?= htmlspecialchars($paiement['type_paiement']) ?> 
                <?php if ($paiement['reference_transaction']): ?>
                    | Réf: <?= htmlspecialchars($paiement['reference_transaction']) ?>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="info-section">
            <div class="info-row">
                <span class="info-label">Mode de paiement:</span>
                <span style="background-color: <?= getModePaiementColor($paiement['mode_paiement']) ?>; 
                             color: white; padding: 4px 12px; border-radius: 15px; font-size: 12px;">
                    <?= htmlspecialchars($paiement['mode_paiement']) ?>
                </span>
            </div>
            <?php if ($paiement['date_echeance']): ?>
            <div class="info-row">
                <span class="info-label">Prochaine échéance:</span>
                <span><?= date('d/m/Y', strtotime($paiement['date_echeance'])) ?></span>
            </div>
            <?php endif; ?>
            <?php if ($paiement['notes']): ?>
            <div class="info-row">
                <span class="info-label">Notes:</span>
                <span><?= htmlspecialchars($paiement['notes']) ?></span>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="signature-section">
            <div class="signature-box">
                <p><strong>Le Locataire</strong></p>
                <div class="signature-line">Signature</div>
            </div>
            <div class="signature-box">
                <p><strong>L'Agence / Propriétaire</strong></p>
                <div class="signature-line">Cachet et Signature</div>
            </div>
        </div>
        
        <div class="footer">
            <p>Cette quittance annule et remplace tout reçu précédent.</p>
            <p>CI Immobilier - Abidjan, Côte d'Ivoire 🇨🇮</p>
            <p>Merci pour votre confiance !</p>
        </div>
    </div>
    
    <?php if ($isPrint): ?>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
    <?php endif; ?>
</body>
</html>

<?php
echo ob_get_clean();
?>
