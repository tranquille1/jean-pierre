<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$pdo = getDBConnection();

// Récupérer le paiement avec les détails et la quittance associée
$stmt = $pdo->prepare("
    SELECT p.*, l.nom, l.prenom, l.cni, l.telephone, l.email, l.adresse_complet,
           pr.titre as propriete_titre, pr.commune, pr.adresse as propriete_adresse, pr.type,
           q.numero_quittance, q.token_verification
    FROM paiements p
    JOIN locataires l ON p.locataire_id = l.id
    LEFT JOIN proprietes pr ON p.propriete_id = pr.id
    LEFT JOIN quittances q ON q.paiement_id = p.id
    WHERE p.id = ?
");
$stmt->execute([$id]);
$paiement = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$paiement) {
    die("Paiement non trouvé");
}

// Si pas de quittance générée, utiliser un numéro par défaut
$numeroQuittance = $paiement['numero_quittance'] ?? genererNumeroQuittance($paiement['id']);
$tokenVerification = $paiement['token_verification'] ?? '';
$linkVerification = $tokenVerification ? generateVerificationLink($id, $tokenVerification) : '';
$isPrint = isset($_GET['print']);

ob_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quittance <?= htmlspecialchars($numeroQuittance) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white; }
            .quittance { box-shadow: none !important; border: 2px solid #333 !important; }
        }

        .quittance {
            max-width: 850px;
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
            font-size: 26px;
            margin: 0;
            font-weight: bold;
        }

        .header .subtitle {
            color: #666;
            font-size: 14px;
            margin-top: 5px;
        }

        .header .flag {
            display: inline-block;
            width: 60px;
            height: 30px;
            background: linear-gradient(90deg, #FF8200 33%, #ffffff 33%, #ffffff 66%, #00A650 66%);
            border: 1px solid #ccc;
            margin-top: 10px;
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
            color: #666;
            font-weight: 600;
        }

        .montant-box {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-left: 5px solid #00A65E;
            padding: 20px;
            margin: 25px 0;
            text-align: center;
        }

        .montant-box .label {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .montant-box .value {
            font-size: 32px;
            font-weight: bold;
            color: #00A65E;
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            gap: 40px;
        }

        .signature-box {
            flex: 1;
            border: 1px solid #ddd;
            padding: 20px;
            text-align: center;
        }

        .signature-line {
            height: 60px;
            margin-top: 10px;
            border: 1px dashed #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 12px;
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #eee;
            text-align: center;
            font-size: 12px;
            color: #999;
        }

        .qr-section {
            text-align: center;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            margin-top: 20px;
        }

        .btn-action {
            margin: 5px;
        }
    </style>
</head>
<body class="bg-light">

    <?php if (!$isPrint): ?>
    <div class="container no-print" style="max-width: 900px;">
        <div class="d-flex justify-content-between align-items-center my-3">
            <a href="paiements.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
            <div>
                <a href="quittance.php?id=<?= $id ?>&print=1" target="_blank" class="btn btn-ci btn-action">
                    <i class="bi bi-printer"></i> Imprimer
                </a>
                <button onclick="window.print()" class="btn btn-outline-primary btn-action">
                    <i class="bi bi-download"></i> Télécharger PDF
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="quittance">
        <div class="header">
            <div class="flag"></div>
            <h1>🇨🇮 QUITTANCE DE PAIEMENT</h1>
            <p class="subtitle">CI Immobilier - République de Côte d'Ivoire</p>
            <p class="mb-0"><strong>N° <?= htmlspecialchars($numeroQuittance) ?></strong></p>
        </div>

        <div class="row">
            <div class="col-md-6">
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
                    <?php if ($paiement['email']): ?>
                    <div class="info-row">
                        <span class="info-label">Email:</span>
                        <span><?= htmlspecialchars($paiement['email']) ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-section">
                    <h5 style="color: #00A65E; border-bottom: 2px solid #00A65E; padding-bottom: 5px;">PAIEMENT</h5>
                    <div class="info-row">
                        <span class="info-label">Date:</span>
                        <span><?= date('d/m/Y', strtotime($paiement['date_paiement'])) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Type:</span>
                        <span><?= htmlspecialchars($paiement['type_paiement']) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Mode:</span>
                        <span style="background-color: <?= getModePaiementColor($paiement['mode_paiement']) ?>;
                                     color: white; padding: 4px 12px; border-radius: 15px; font-size: 12px;">
                            <?= htmlspecialchars($paiement['mode_paiement']) ?>
                        </span>
                    </div>
                    <?php if ($paiement['reference_transaction']): ?>
                    <div class="info-row">
                        <span class="info-label">Référence:</span>
                        <span><?= htmlspecialchars($paiement['reference_transaction']) ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if ($paiement['propriete_titre']): ?>
        <div class="info-section">
            <h5 style="color: #00A65E; border-bottom: 2px solid #00A65E; padding-bottom: 5px;">PROPRIÉTÉ LOUÉE</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="info-row">
                        <span class="info-label">Désignation:</span>
                        <span><?= htmlspecialchars($paiement['propriete_titre']) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Type:</span>
                        <span><?= htmlspecialchars($paiement['type']) ?></span>
                    </div>
                </div>
                <div class="col-md-6">
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
            </div>
        </div>
        <?php endif; ?>

        <div class="montant-box">
            <div class="label">MONTANT PAYÉ</div>
            <div class="value"><?= formatFCFA($paiement['montant']) ?></div>
            <div class="label" style="margin-top: 10px;">
                <?= htmlspecialchars($paiement['type_paiement']) ?>
                <?php if ($paiement['reference_transaction']): ?>
                    | Réf: <?= htmlspecialchars($paiement['reference_transaction']) ?>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($paiement['date_echeance']): ?>
        <div class="info-section">
            <div class="info-row">
                <span class="info-label">Prochaine échéance:</span>
                <span><strong><?= date('d/m/Y', strtotime($paiement['date_echeance'])) ?></strong></span>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($paiement['notes']): ?>
        <div class="info-section">
            <div class="info-row">
                <span class="info-label">Notes:</span>
                <span><?= htmlspecialchars($paiement['notes']) ?></span>
            </div>
        </div>
        <?php endif; ?>

        <!-- QR Code de vérification -->
        <?php if ($linkVerification): ?>
        <div class="qr-section no-print">
            <img src="<?= getQRCodeUrl($linkVerification) ?>" alt="QR Code de vérification" style="max-width: 150px;">
            <p class="mt-2 mb-0 text-muted small">Scannez ce QR Code pour vérifier l'authenticité de cette quittance</p>
            <p class="mt-1 text-muted small" style="font-size: 10px;"><?= htmlspecialchars($linkVerification) ?></p>
        </div>
        <?php endif; ?>

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
            <p><strong>Cette quittance annule et remplace tout reçu précédent.</strong></p>
            <p>Pour vérifier son authenticité, scannez le QR Code ci-dessus ou rendez-vous sur notre portail de vérification.</p>
            <p>CI Immobilier - Abidjan, Côte d'Ivoire 🇨🇮 | Tél: +225 XX XX XX XX XX</p>
            <p>Merci pour votre confiance !</p>
        </div>
    </div>

    <?php if ($isPrint): ?>
    <script>
        window.onload = function() {
            setTimeout(function() { window.print(); }, 500);
        };
    </script>
    <?php endif; ?>
</body>
</html>

<?php
echo ob_get_clean();
?>
