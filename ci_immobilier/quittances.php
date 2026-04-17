<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

$pageTitle = 'Quittances';
$pdo = getDBConnection();

// Récupérer toutes les quittances (paiements)
$quittances = $pdo->query("
    SELECT p.*, l.nom, l.prenom, l.cni, l.telephone, pr.titre as propriete_titre, pr.commune, pr.adresse
    FROM paiements p
    JOIN locataires l ON p.locataire_id = l.id
    LEFT JOIN proprietes pr ON p.propriete_id = pr.id
    ORDER BY p.created_at DESC
")->fetchAll(PDO::FETCH_ASSOC);

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-receipt"></i> Quittances de Paiement</h2>
    <a href="ajouter_paiement.php" class="btn btn-ci">
        <i class="bi bi-plus-circle"></i> Nouveau paiement
    </a>
</div>

<!-- Liste des quittances -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>N° Quittance</th>
                        <th>Date</th>
                        <th>Locataire</th>
                        <th>Type</th>
                        <th>Mode</th>
                        <th>Montant</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($quittances as $q): ?>
                    <tr>
                        <td>
                            <code><?= genererNumeroQuittance($q['id']) ?></code>
                        </td>
                        <td><?= date('d/m/Y', strtotime($q['date_paiement'])) ?></td>
                        <td>
                            <strong><?= htmlspecialchars($q['nom'] . ' ' . $q['prenom']) ?></strong>
                        </td>
                        <td>
                            <span class="badge bg-secondary"><?= htmlspecialchars($q['type_paiement']) ?></span>
                        </td>
                        <td>
                            <span class="mode-paiement-badge" style="background-color: <?= getModePaiementColor($q['mode_paiement']) ?>">
                                <?= htmlspecialchars($q['mode_paiement']) ?>
                            </span>
                        </td>
                        <td class="text-success fw-bold"><?= formatFCFA($q['montant']) ?></td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="quittance.php?id=<?= $q['id'] ?>" class="btn btn-outline-primary" title="Voir quittance">
                                    <i class="bi bi-eye"></i> Voir
                                </a>
                                <a href="quittance.php?id=<?= $q['id'] ?>&print=1" class="btn btn-outline-success" title="Imprimer quittance" target="_blank">
                                    <i class="bi bi-printer"></i> Imprimer
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if (empty($quittances)): ?>
<div class="alert alert-info text-center mt-3">
    <i class="bi bi-info-circle"></i> Aucune quittance disponible. Enregistrez d'abord un paiement.
</div>
<?php endif; ?>

<?php
$content = ob_get_clean();
include 'templates/layout.php';
?>
