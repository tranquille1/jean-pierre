<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'CI Immobilier' ?> - Gestion Immobilière Ivoirienne</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        :root {
            --ci-orange: #FF7900;
            --ci-white: #FFFFFF;
            --ci-green: #00A65E;
        }
        
        body {
            background-color: #f8f9fa;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--ci-orange) 0%, var(--ci-white) 50%, var(--ci-green) 100%);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: bold;
            color: #333 !important;
        }
        
        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        
        .card:hover {
            transform: translateY(-2px);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--ci-orange), #ff9500);
            color: white;
            font-weight: bold;
        }
        
        .btn-ci {
            background: linear-gradient(135deg, var(--ci-orange), var(--ci-green));
            color: white;
            border: none;
        }
        
        .btn-ci:hover {
            opacity: 0.9;
            color: white;
        }
        
        .badge-orange { background-color: var(--ci-orange); }
        .badge-green { background-color: var(--ci-green); }
        
        .stat-card {
            border-left: 4px solid var(--ci-orange);
        }
        
        .mode-paiement-badge {
            padding: 6px 12px;
            border-radius: 20px;
            color: white;
            font-size: 0.85em;
            display: inline-block;
        }
        
        footer {
            background: #333;
            color: white;
            padding: 20px 0;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-building"></i> CI Immobilier
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php"><i class="bi bi-speedometer2"></i> Tableau de bord</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="proprietes.php"><i class="bi bi-house"></i> Propriétés</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="locataires.php"><i class="bi bi-people"></i> Locataires</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="paiements.php"><i class="bi bi-cash-coin"></i> Paiements</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="quittances.php"><i class="bi bi-receipt"></i> Quittances</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-4">
        <?php if (isset($message)): ?>
            <div class="alert alert-<?= $messageType ?? 'info' ?> alert-dismissible fade show" role="alert">
                <?= $message ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?= $content ?>
    </main>

    <footer>
        <div class="container text-center">
            <p>&copy; <?= date('Y') ?> CI Immobilier - Gestion Immobilière adaptée à la Côte d'Ivoire 🇨🇮</p>
            <p class="small">Supporte Orange Money, MTN MoMo et Wave</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>
</html>
