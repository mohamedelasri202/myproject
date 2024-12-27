<?php

class Utilisateur {
    protected $id;
    protected $name;
    protected $email;
    protected $password;
    protected $id_role;
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getPdo() {
        return $this->pdo;
    }

    // Méthode pour inscrire un utilisateur
    public function sInscrire($name, $email, $password, $id_role) {
        try {
            $query = "SELECT status FROM utilisateur WHERE email = :email";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([':email' => $email]);
            $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existingUser) {
                if ($existingUser['status'] == 'banni' || $existingUser['status'] == 'archivé') {
                    // Stocke l'erreur dans la session pour l'afficher plus tard
                    $_SESSION['error_message'] = "Cet utilisateur est banni ou archivé et ne peut pas se réinscrire.";
                    // Redirection vers la page de connexion
                    header("Location: sign_in.php");
                    exit();
                }
            }

            // Hachage du mot de passe
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT); 
            $query = "INSERT INTO utilisateur (name, email, password, id_role) VALUES (:name, :email, :password, :id_role)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':password' => $hashedPassword,
                ':id_role' => $id_role
            ]);
            echo "Utilisateur inscrit avec succès.";
        } catch (PDOException $e) {
            echo "Erreur lors de l'inscription : " . $e->getMessage();
        }
    }

    // Méthode pour connecter un utilisateur
    public function seConnecter($email, $password) {
        session_start(); // On commence la session ici pour pouvoir utiliser $_SESSION
        try {
            $query = "SELECT * FROM utilisateur WHERE email = :email";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([':email' => $email]);

            // Vérifier si l'utilisateur existe
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$user) {
                echo "Aucun utilisateur trouvé avec cet email.";
                return;
            }

            // Vérifier le mot de passe
            if (password_verify($password, $user['password'])) {
                // Vérifier si l'utilisateur est banni ou archivé
                if ($user['status'] == 'banni' || $user['status'] == 'archivé') {
                    // Stocker le message d'erreur dans la session et rediriger vers la page de connexion
                    $_SESSION['error_message'] = "Cet utilisateur est banni ou archivé et ne peut pas se connecter.";
                    header("Location: sign_in.php");
                    exit();
                }

                // Démarrer la session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_role'] = $user['id_role'];

                // Vérifier le rôle et rediriger vers la bonne page
                if ($user['id_role'] == 1 || $user['id_role'] == 3) {
                    header("Location: dashboord.php"); // Page dashboard pour admin et autre rôle
                    exit();
                } else {
                    header("Location: home.php"); // Page home pour les autres utilisateurs
                    exit();
                }
            } else {
                echo "Identifiants incorrects.";
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la connexion : " . $e->getMessage();
        }
    }
}
?>
