<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

$pageTitle = 'Tableau de bord';
$pdo = getDBConnection();

// Statistiques
$totalProprietes = $pdo->query("SELECT COUNT(*) FROM proprietes")->fetchColumn();
$proprietesDisponibles = $pdo->query("SELECT COUNT(*) FROM proprietes WHERE statut = 'Disponible'")->fetchColumn();
$proprietesLouees = $pdo->query("SELECT COUNT(*) FROM proprietes WHERE statut = 'Loué'")->fetchColumn();
$totalLocataires = $pdo->query("SELECT COUNT(*) FROM locataires")->fetchColumn();
$totalPaiements = $pdo->query("SELECT SUM(montant) FROM paiements")->fetchColumn() ?? 0;
$paiementsMois = $pdo->query("SELECT SUM(montant) FROM paiements WHERE MONTH(date_paiement) = MONTH(CURRENT_DATE()) AND YEAR(date_paiement) = YEAR(CURRENT_DATE())")->fetchColumn() ?? 0;

// Dernières propriétés
$dernieresProprietes = $pdo->query("SELECT * FROM proprietes ORDER BY date_creation DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);

// Derniers paiements
$derniersPaiements = $pdo->query("
    SELECT p.*, l.nom, l.prenom 
    FROM paiements p 
    JOIN locataires l ON p.locataire_id = l.id 
    ORDER BY p.date_paiement DESC 
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);

ob_start();
?>

<div class="row mb-4">
    <div class="col-12">
        <h2><i class="bi bi-speedometer2"></i> Tableau de bord</h2>
        <p class="text-muted">Gestion immobilière adaptée à la Côte d'Ivoire</p>
    </div>
</div>

<!-- Statistiques -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Total Propriétés</h6>
                        <h3 class="mb-0"><?= $totalProprietes ?></h3>
                    </div>
                    <i class="bi bi-building fs-1 text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card stat-card h-100" style="border-left-color: #28a745;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Disponibles</h6>
                        <h3 class="mb-0"><?= $proprietesDisponibles ?></h3>
                    </div>
                    <i class="bi bi-house-check fs-1 text-success"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card stat-card h-100" style="border-left-color: #dc3545;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Louées</h6>
                        <h3 class="mb-0"><?= $proprietesLouees ?></h3>
                    </div>
                    <i class="bi bi-house-x fs-1 text-danger"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card stat-card h-100" style="border-left-color: #ffc107;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Locataires</h6>
                        <h3 class="mb-0"><?= $totalLocataires ?></h3>
                    </div>
                    <i class="bi bi-people fs-1 text-warning"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Revenus -->
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-cash-stack"></i> Revenus du mois
            </div>
            <div class="card-body">
                <h2 class="text-success"><?= formatFCFA($paiementsMois) ?></h2>
                <p class="text-muted">Paiements reçus ce mois-ci</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-graph-up"></i> Revenus totaux
            </div>
            <div class="card-body">
                <h2 class="text-primary"><?= formatFCFA($totalPaiements) ?></h2>
                <p class="text-muted">Cumul de tous les paiements</p>
            </div>
        </div>
    </div>
</div>

<!-- Dernières propriétés et Paiements -->
<div class="row g-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-building"></i> Dernières propriétés</span>
                <a href="proprietes.php" class="btn btn-sm btn-light">Voir tout</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Commune</th>
                                <th>Prix</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dernieresProprietes as $prop): ?>
                            <tr>
                                <td><?= htmlspecialchars($prop['titre']) ?></td>
                                <td><?= htmlspecialchars($prop['commune']) ?></td>
                                <td><?= formatFCFA($prop['prix_loyer']) ?></td>
                                <td><?= getStatutBadge($prop['statut']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-cash-coin"></i> Derniers paiements</span>
                <a href="paiements.php" class="btn btn-sm btn-light">Voir tout</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Locataire</th>
                                <th>Type</th>
                                <th>Mode</th>
                                <th>Montant</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($derniersPaiements as $paiement): ?>
                            <tr>
                                <td><?= htmlspecialchars($paiement['nom'] . ' ' . $paiement['prenom']) ?></td>
                                <td><?= htmlspecialchars($paiement['type_paiement']) ?></td>
                                <td>
                                    <span class="mode-paiement-badge" style="background-color: <?= getModePaiementColor($paiement['mode_paiement']) ?>">
                                        <?= htmlspecialchars($paiement['mode_paiement']) ?>
                                    </span>
                                </td>
                                <td class="text-success"><?= formatFCFA($paiement['montant']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12 text-center">
        <a href="proprietes.php" class="btn btn-ci btn-lg me-2"><i class="bi bi-plus-circle"></i> Ajouter une propriété</a>
        <a href="locataires.php" class="btn btn-outline-primary btn-lg"><i class="bi bi-person-plus"></i> Nouveau locataire</a>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'templates/layout.php';
?>
