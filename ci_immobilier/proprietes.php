<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

$pageTitle = 'Propriétés';
$pdo = getDBConnection();
$message = null;
$messageType = 'info';

// Supprimer une propriété
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM proprietes WHERE id = ?")->execute([$id]);
    $message = "Propriété supprimée avec succès";
    $messageType = 'success';
}

// Récupérer toutes les propriétés
$filter = $_GET['filter'] ?? 'all';
$sql = "SELECT * FROM proprietes";
if ($filter === 'disponible') {
    $sql .= " WHERE statut = 'Disponible'";
} elseif ($filter === 'loue') {
    $sql .= " WHERE statut = 'Loué'";
}
$sql .= " ORDER BY date_creation DESC";
$proprietes = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-building"></i> Gestion des Propriétés</h2>
    <div>
        <a href="proprietes.php?filter=all" class="btn btn-outline-secondary btn-sm me-1">
            <i class="bi bi-list-ul"></i> Toutes
        </a>
        <a href="proprietes.php?filter=disponible" class="btn btn-outline-success btn-sm me-1">
            <i class="bi bi-house-check"></i> Disponibles
        </a>
        <a href="proprietes.php?filter=loue" class="btn btn-outline-danger btn-sm me-1">
            <i class="bi bi-house-x"></i> Louées
        </a>
        <a href="ajouter_propriete.php" class="btn btn-ci">
            <i class="bi bi-plus-circle"></i> Nouvelle propriété
        </a>
    </div>
</div>

<!-- Liste des propriétés -->
<div class="row g-4">
    <?php foreach ($proprietes as $prop): ?>
    <div class="col-md-6 col-lg-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><?= htmlspecialchars($prop['type']) ?></span>
                <?= getStatutBadge($prop['statut']) ?>
            </div>
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($prop['titre']) ?></h5>
                <p class="card-text text-muted">
                    <i class="bi bi-geo-alt"></i> <?= htmlspecialchars($prop['commune']) ?><br>
                    <?php if ($prop['adresse']): ?>
                        <small><?= htmlspecialchars($prop['adresse']) ?></small>
                    <?php endif; ?>
                </p>
                <div class="row small text-muted mb-3">
                    <?php if ($prop['nb_pieces']): ?>
                    <div class="col-6"><i class="bi bi-door-open"></i> <?= $prop['nb_pieces'] ?> pièces</div>
                    <?php endif; ?>
                    <?php if ($prop['superficie']): ?>
                    <div class="col-6"><i class="bi bi-rulers"></i> <?= $prop['superficie'] ?> m²</div>
                    <?php endif; ?>
                </div>
                <h4 class="text-primary"><?= formatFCFA($prop['prix_loyer']) ?></h4>
                <?php if ($prop['proprietaire_nom']): ?>
                <p class="small text-muted mt-2">
                    <i class="bi bi-person"></i> <?= htmlspecialchars($prop['proprietaire_nom']) ?>
                    <?php if ($prop['proprietaire_telephone']): ?>
                        - <i class="bi bi-telephone"></i> <?= formatTelephone($prop['proprietaire_telephone']) ?>
                    <?php endif; ?>
                </p>
                <?php endif; ?>
            </div>
            <div class="card-footer bg-white">
                <div class="btn-group w-100" role="group">
                    <a href="quittance.php?id=<?= $prop['id'] ?>" class="btn btn-sm btn-outline-info" title="Voir les paiements liés">
                        <i class="bi bi-receipt"></i> Paiements
                    </a>
                    <a href="proprietes.php?delete=<?= $prop['id'] ?>" class="btn btn-sm btn-outline-danger" 
                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette propriété ?')">
                        <i class="bi bi-trash"></i> Supprimer
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php if (empty($proprietes)): ?>
<div class="alert alert-info text-center">
    <i class="bi bi-info-circle"></i> Aucune propriété trouvée. Commencez par ajouter une propriété.
</div>
<?php endif; ?>

<?php
$content = ob_get_clean();
include 'templates/layout.php';
?>
