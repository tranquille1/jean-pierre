<?php
/**
 * Installation de la base de données
 * Exécutez ce fichier une fois pour créer les tables
 */

require_once 'config/database.php';

try {
    initDatabase();
    echo "✅ Base de données installée avec succès !";
    echo "<br><br>";
    echo "Tables créées :";
    echo "<ul>";
    echo "<li>proprietes</li>";
    echo "<li>locataires</li>";
    echo "<li>paiements</li>";
    echo "</ul>";
    echo "<br>";
    echo "<a href='index.php'>Accéder au tableau de bord</a>";
} catch (Exception $e) {
    echo "❌ Erreur : " . $e->getMessage();
}
