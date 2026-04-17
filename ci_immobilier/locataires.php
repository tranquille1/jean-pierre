<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

$pageTitle = 'Locataires';
$pdo = getDBConnection();

// Supprimer un locataire
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM locataires WHERE id = ?")->execute([$id]);
    header('Location: locataires.php');
    exit();
}

// Récupérer tous les locataires avec leurs propriétés
$locataires = $pdo->query("
    SELECT l.*, p.titre as propriete_titre, p.commune 
    FROM locataires l 
    LEFT JOIN proprietes p ON l.propriete_id = p.id 
    ORDER BY l.date_entree DESC
")->fetchAll(PDO::FETCH_ASSOC);

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-people"></i> Gestion des Locataires</h2>
    <a href="ajouter_locataire.php" class="btn btn-ci">
        <i class="bi bi-person-plus"></i> Nouveau locataire
    </a>
</div>

<!-- Liste des locataires -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nom & Prénom</th>
                        <th>CNI</th>
                        <th>Téléphone</th>
                        <th>Profession</th>
                        <th>Propriété</th>
                        <th>Date d'entrée</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($locataires as $loc): ?>
                    <tr>
                        <td>
                            <strong><?= htmlspecialchars($loc['nom']) ?></strong><br>
                            <small class="text-muted"><?= htmlspecialchars($loc['prenom']) ?></small>
                        </td>
                        <td>
                            <?php if ($loc['cni']): ?>
                                <span class="badge bg-secondary"><?= htmlspecialchars($loc['cni']) ?></span>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($loc['telephone']): ?>
                                <?= formatTelephone($loc['telephone']) ?>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($loc['profession'] ?? '-') ?></td>
                        <td>
                            <?php if ($loc['propriete_titre']): ?>
                                <small>
                                    <?= htmlspecialchars($loc['propriete_titre']) ?><br>
                                    <span class="text-muted"><?= htmlspecialchars($loc['commune']) ?></span>
                                </small>
                            <?php else: ?>
                                <span class="text-muted">Aucune</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($loc['date_entree']): ?>
                                <?= date('d/m/Y', strtotime($loc['date_entree'])) ?>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="modifier_locataire.php?id=<?= $loc['id'] ?>" class="btn btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="locataires.php?delete=<?= $loc['id'] ?>" class="btn btn-outline-danger"
                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce locataire ?')">
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

<?php if (empty($locataires)): ?>
<div class="alert alert-info text-center mt-3">
    <i class="bi bi-info-circle"></i> Aucun locataire enregistré. Commencez par ajouter un locataire.
</div>
<?php endif; ?>

<?php
$content = ob_get_clean();
include 'templates/layout.php';
?>
