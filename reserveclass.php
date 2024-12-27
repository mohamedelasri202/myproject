<?php
include 'Database.php';
class Reservation {
    private $pdo;
    
    public function __construct() {
        $database = new Database();
        $this->pdo = $database->connect();
    }
    
    public function createReservation($userId, $activityId) {
        if (!$userId) {
            throw new Exception("User login required");
        }
        
        if (!$activityId) {
            throw new Exception("Invalid activity");
        }
        
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO Reservations (utilisateur, activities, status, total_price) 
                SELECT ?, ?, 'pending', price 
                FROM Activities 
                WHERE id = ?
            ");
            
            return $stmt->execute([$userId, $activityId, $activityId]);
        } catch (PDOException $e) {
            throw new Exception("Reservation creation failed");
        }
    }
    
    public function getAllReservations() {
        $sql = "SELECT 
                    r.*, 
                    u.name as client_name,
                    u.email as client_email,
                    a.name as activity_name,
                    a.description as activity_description,
                    a.location as destination
                FROM Reservations r
                JOIN utilisateur u ON r.utilisateur = u.id
                JOIN Activities a ON r.activities = a.id
                ORDER BY r.created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getReservationById($reservationId) {
        $sql = "SELECT 
                    r.*, 
                    u.name as client_name,
                    u.email as client_email,
                    a.name as activity_name,
                    a.description as activity_description,
                    a.location as destination
                FROM Reservations r
                JOIN utilisateur u ON r.utilisateur = u.id
                JOIN Activities a ON r.activities = a.id
                WHERE r.id = ?";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$reservationId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function updateStatus($reservationId, $newStatus) {
        $sql = "UPDATE Reservations SET status = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$newStatus, $reservationId]);
    }
    
    public function deleteReservation($reservationId) {
        $sql = "DELETE FROM Reservations WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$reservationId]);
    }
}

// Usage example:
session_start();

try {
    $reservationSystem = new Reservation();
    
    // For creating new reservation
    if (isset($_POST['activity_id'])) {
        if ($reservationSystem->createReservation($_SESSION['user_id'], $_POST['activity_id'])) {
            header("Location: activite.php?success=reservation_created");
        } else {
            header("Location: activite.php?error=reservation_failed");
        }
        exit();
    }
    
    // For managing reservations
    if (isset($_POST['update_status'])) {
        $reservationSystem->updateStatus($_POST['reservation_id'], $_POST['status']);
        header("Location: reservations.php");
        exit();
    }
    
    if (isset($_POST['delete_reservation'])) {
        $reservationSystem->deleteReservation($_POST['delete_reservation']);
        header("Location: reservations.php");
        exit();
    }
    
    // Get all reservations
    $reservations = $reservationSystem->getAllReservations();
    
} catch (Exception $e) {
    header("Location: activite.php?error=" . urlencode($e->getMessage()));
    exit();
}
?>