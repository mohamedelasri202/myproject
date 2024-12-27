<?php


require_once 'Database.php';
require_once 'Utilisateur.php';


session_start();
if (isset($_SESSION['error_message'])) {
    echo $_SESSION['error_message'];
    unset($_SESSION['error_message']); // Efface le message après l'affichage
}



$db = new Database();
$pdo = $db->connect();



$message = ""; // Message d'erreur

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $utilisateur = new Utilisateur($pdo);

    ob_start();
    $utilisateur->seConnecter($email, $password);
    $message = ob_get_clean(); // Capture du message d'erreur
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In Modal</title>
  <link rel="stylesheet" href="sign.css">
  <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
</head>
<body>

  
  <div class="form-container">

   <form action="" method="post">
      <h3>login now</h3>
      <?php if (!empty($message)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($message); ?></p>
      <?php endif; ?>
      <input type="email" name="email" required placeholder="enter your email">
      <input type="password" name="password" required placeholder="enter your password">
      <input type="submit" name="submit" value="login now" class="form-btn">
      <p>don't have an account? <a href="sign_up.php">register now</a></p>
   </form>

</div>


</body>
</html>