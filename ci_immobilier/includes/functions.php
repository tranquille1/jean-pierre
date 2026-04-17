<?php
/**
 * Fonctions utilitaires
 */

// Formater un numéro de téléphone ivoirien
function formatTelephone($tel) {
    $tel = preg_replace('/[^0-9]/', '', $tel);
    if (strlen($tel) == 10 && substr($tel, 0, 2) == '07') {
        return '+225 ' . substr($tel, 0, 2) . ' ' . substr($tel, 2, 2) . ' ' . substr($tel, 4, 2) . ' ' . substr($tel, 6, 2) . ' ' . substr($tel, 8, 2);
    }
    if (strlen($tel) == 8) {
        return '+225 ' . substr($tel, 0, 2) . ' ' . substr($tel, 2, 2) . ' ' . substr($tel, 4, 2) . ' ' . substr($tel, 6, 2);
    }
    return $tel;
}

// Formater un montant en FCFA
function formatFCFA($montant) {
    return number_format($montant, 0, ',', ' ') . ' FCFA';
}

// Générer un numéro de quittance
function genererNumeroQuittance($id) {
    return 'QTC-' . date('Ymd') . '-' . str_pad($id, 4, '0', STR_PAD_LEFT);
}

// Obtenir la couleur du mode de paiement
function getModePaiementColor($mode) {
    $colors = [
        'Orange Money' => '#ff7900',
        'MTN MoMo' => '#ffcc00',
        'Wave' => '#1dc4ff',
        'Espèces' => '#28a745',
        'Chèque' => '#6c757d',
        'Virement bancaire' => '#007bff'
    ];
    return $colors[$mode] ?? '#6c757d';
}

// Obtenir le statut badge
function getStatutBadge($statut) {
    if ($statut === 'Disponible') {
        return '<span class="badge bg-success">Disponible</span>';
    }
    return '<span class="badge bg-danger">Loué</span>';
}

// Redirection sécurisée
function redirect($url) {
    header("Location: $url");
    exit();
}

// Vérifier si la requête est POST
function isPost() {
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

// Nettoyer les entrées
function cleanInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}
