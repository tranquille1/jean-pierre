<?php
/**
 * Configuration de la base de données
 * CI Immobilier - Gestion Immobilière Ivoirienne
 */

define('DB_HOST', 'localhost');
define('DB_NAME', 'ci_immobilier');
define('DB_USER', 'root');
define('DB_PASS', '');

// Communes ivoiriennes
$communes = [
    'Cocody', 'Yopougon', 'Plateau', 'Marcory', 'Treichville',
    'Adjamé', 'Abobo', 'Koumassi', 'Port-Bouët', 'Attécoubé',
    'Bingerville', 'Songon', 'Anyama'
];

// Types de logements
$types_logement = [
    'Studio', 'Appartement', 'Villa', 'Duplex', 
    'Chambre', 'Local commercial', 'Terrain'
];

// Modes de paiement (spécifique Côte d'Ivoire)
$modes_paiement = [
    'Orange Money' => 'orange',
    'MTN MoMo' => 'mtn',
    'Wave' => 'wave',
    'Espèces' => 'especes',
    'Chèque' => 'cheque',
    'Virement bancaire' => 'virement'
];

// Types de paiement
$types_paiement = [
    'Loyer',
    'Caution',
    'Électricité (CIE)',
    'Eau (SODECI)',
    'Frais d\'entretien',
    'Autre'
];

// Fonction de connexion à la base de données
function getDBConnection() {
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USER,
            DB_PASS,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        return $pdo;
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }
}

// Initialiser la base de données
function initDatabase() {
    $pdo = getDBConnection();
    
    // Table propriétés
    $pdo->exec("CREATE TABLE IF NOT EXISTS proprietes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        titre VARCHAR(255) NOT NULL,
        type VARCHAR(100) NOT NULL,
        commune VARCHAR(100) NOT NULL,
        adresse TEXT,
        nb_pieces INT,
        superficie DECIMAL(10,2),
        prix_loyer DECIMAL(15,2) NOT NULL,
        statut ENUM('Disponible', 'Loué') DEFAULT 'Disponible',
        proprietaire_nom VARCHAR(255),
        proprietaire_telephone VARCHAR(20),
        date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    
    // Table locataires
    $pdo->exec("CREATE TABLE IF NOT EXISTS locataires (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(255) NOT NULL,
        prenom VARCHAR(255) NOT NULL,
        cni VARCHAR(50),
        telephone VARCHAR(20),
        email VARCHAR(255),
        profession VARCHAR(255),
        adresse_complet TEXT,
        date_entree DATE,
        propriete_id INT,
        FOREIGN KEY (propriete_id) REFERENCES proprietes(id) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    
    // Table paiements
    $pdo->exec("CREATE TABLE IF NOT EXISTS paiements (
        id INT AUTO_INCREMENT PRIMARY KEY,
        locataire_id INT NOT NULL,
        propriete_id INT,
        montant DECIMAL(15,2) NOT NULL,
        type_paiement VARCHAR(100) NOT NULL,
        mode_paiement VARCHAR(50) NOT NULL,
        reference_transaction VARCHAR(100),
        date_paiement DATE NOT NULL,
        date_echeance DATE,
        notes TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (locataire_id) REFERENCES locataires(id) ON DELETE CASCADE,
        FOREIGN KEY (propriete_id) REFERENCES proprietes(id) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    
    // Ajouter un index pour les recherches
    $pdo->exec("CREATE INDEX IF NOT EXISTS idx_statut ON proprietes(statut)");
    $pdo->exec("CREATE INDEX IF NOT EXISTS idx_commune ON proprietes(commune)");
}
