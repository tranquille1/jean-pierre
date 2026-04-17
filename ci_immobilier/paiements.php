<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

$pageTitle = 'Paiements';
$pdo = getDBConnection();

// Supprimer un paiement
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM paiements WHERE id = ?")->execute([$id]);
    header('Location: paiements.php');
    exit();
}

// Récupérer tous les paiements avec les détails des locataires et propriétés
$paiements = $pdo->query("
    SELECT p.*, l.nom, l.prenom, pr.titre as propriete_titre, pr.commune
    FROM paiements p
    JOIN locataires l ON p.locataire_id = l.id
    LEFT JOIN proprietes pr ON p.propriete_id = pr.id
    ORDER BY p.date_paiement DESC
")->fetchAll(PDO::FETCH_ASSOC);

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-cash-coin"></i> Gestion des Paiements</h2>
    <a href="ajouter_paiement.php" class="btn btn-ci">
        <i class="bi bi-plus-circle"></i> Nouveau paiement
    </a>
</div>

<!-- Statistiques rapides -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6>Total des paiements</h6>
                <h4><?= formatFCFA(array_sum(array_column($paiements, 'montant'))) ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6>Paiements du mois</h6>
                <?php
                $moisActuel = date('Y-m');
                $totalMois = 0;
                foreach ($paiements as $p) {
                    if (date('Y-m', strtotime($p['date_paiement'])) === $moisActuel) {
                        $totalMois += $p['montant'];
                    }
                }
                ?>
                <h4><?= formatFCFA($totalMois) ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h6>Nombre de paiements</h6>
                <h4><?= count($paiements) ?></h4>
            </div>
        </div>
    </div>
</div>

<!-- Liste des paiements -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Locataire</th>
                        <th>Type</th>
                        <th>Mode</th>
                        <th>Référence</th>
                        <th>Montant</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($paiements as $paiement): ?>
                    <tr>
                        <td><?= date('d/m/Y', strtotime($paiement['date_paiement'])) ?></td>
                        <td>
                            <strong><?= htmlspecialchars($paiement['nom'] . ' ' . $paiement['prenom']) ?></strong>
                        </td>
                        <td>
                            <span class="badge bg-secondary"><?= htmlspecialchars($paiement['type_paiement']) ?></span>
                        </td>
                        <td>
                            <span class="mode-paiement-badge" style="background-color: <?= getModePaiementColor($paiement['mode_paiement']) ?>">
                                <?= htmlspecialchars($paiement['mode_paiement']) ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($paiement['reference_transaction']): ?>
                                <small><code><?= htmlspecialchars($paiement['reference_transaction']) ?></code></small>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-success fw-bold"><?= formatFCFA($paiement['montant']) ?></td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="quittance.php?id=<?= $paiement['id'] ?>" class="btn btn-outline-primary" title="Voir quittance">
                                    <i class="bi bi-eye"></i> Voir
                                </a>
                                <a href="quittance.php?id=<?= $paiement['id'] ?>&print=1" class="btn btn-outline-success" title="Imprimer quittance" target="_blank">
                                    <i class="bi bi-printer"></i> Imprimer
                                </a>
                                <a href="paiements.php?delete=<?= $paiement['id'] ?>" class="btn btn-outline-danger"
                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce paiement ?')" title="Supprimer">
                                    <i class="bi bi-trash"></i>
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

<?php if (empty($paiements)): ?>
<div class="alert alert-info text-center mt-3">
    <i class="bi bi-info-circle"></i> Aucun paiement enregistré. Commencez par ajouter un paiement.
</div>
<?php endif; ?>

<?php
$content = ob_get_clean();
include 'templates/layout.php';
?>
