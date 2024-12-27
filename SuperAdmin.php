<?php
require_once('Utilisateur.php');

class SuperAdmin extends Utilisateur {
    public function __construct($pdo) {
        parent::__construct($pdo);
    }

    // Ensure only superadmin can execute the following methods
    private function isSuperAdmin() {
        // Vérifie si la session est déjà démarrée avant de l'initialiser
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 3) {
            throw new Exception("Access denied: You are not authorized to perform this action.");
        }
    }

    public function archiverUtilisateur($userId) {
        try {
            $this->isSuperAdmin(); // Check role
            $query = "UPDATE utilisateur SET status = 'archivé' WHERE id = :id";
            $stmt = $this->getPdo()->prepare($query);
            $stmt->execute([':id' => $userId]);
            echo "Utilisateur archivé avec succès.";
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    public function bannirUtilisateur($userId) {
        try {
            $this->isSuperAdmin(); // Check role
            $query = "UPDATE utilisateur SET status = 'banni' WHERE id = :id";
            $stmt = $this->getPdo()->prepare($query);
            $stmt->execute([':id' => $userId]);
            echo "Utilisateur banni avec succès.";
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
    
}
?>
