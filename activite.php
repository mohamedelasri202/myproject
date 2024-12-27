<?php
session_start();

// Show messages if they exist
if (isset($_GET['success'])) {
    echo '<div class="alert alert-success">Reservation successful!</div>';
}
if (isset($_GET['error'])) {
    $error = $_GET['error'];
    if ($error === 'login_required') {
        echo '<div class="alert alert-danger">Please login to make a reservation.</div>';
    } else if ($error === 'reservation_failed') {
        echo '<div class="alert alert-danger">Failed to create reservation. Please try again.</div>';
    }
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page with error message if not logged in
    header('Location: yourpage.php?error=login_required');
    exit();
}

// Process reservation (example code)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // If form is submitted, do reservation logic here
    // Example: Check if user is logged in and create a reservation
    if (isset($_SESSION['user_id'])) {
        // Perform reservation logic here
        $reservation_success = true;  // Simulating reservation success
        if ($reservation_success) {
            // Redirect with success message
            header('Location: yourpage.php?success=true');
            exit();
        } else {
            // Redirect with error message if reservation fails
            header('Location: yourpage.php?error=reservation_failed');
            exit();
        }
    }
}

include 'Database.php';

$database = new Database();
$conn = $database->connect();

$sql = "SELECT * FROM Activities"; 
$stmt = $conn->prepare($sql);
$stmt->execute();
$activities = $stmt->fetchAll();
?>

<!-- HTML to display activities and reservation form -->




<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Website</title>

    <link rel="stylesheet" href="style.css">

    <!-- Bootstrap Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Bootstrap Link -->


    <!-- Font Awesome Cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <!-- Font Awesome Cdn -->


    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
    <!-- Google Fonts -->
</head>
<body>

<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg" id="navbar">
        <div class="container">
          <a class="navbar-brand" href="index.html" id="logo"><span>T</span>ravel</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span><i class="fa-solid fa-bars"></i></span>
          </button>
          <div class="collapse navbar-collapse" id="mynavbar">
            <ul class="navbar-nav me-auto">
              <li class="nav-item">
                <a class="nav-link active" href="home.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="activite.php">Activities</a>
              </li>
              <!-- <li class="nav-item">
                <a class="nav-link" href="#packages">Packages</a>
              </li> -->
              <li class="nav-item">
                <a class="nav-link" href="#services">Services</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#gallary">Gallary</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#about">About</a>
              </li>
             
            </ul>
            <form class="d-flex">
              <input class="form-control me-2" type="text" placeholder="Search">
              <button class="btn btn-primary" type="button">Search</button>
            </form>

            <!-- Icone User -->
      <a href="sign_in.php" class="user-icon">
        <i class="fa-solid fa-user"></i>
      </a>
      
          </div>
        </div>
      </nav>
    <!-- Navbar End -->





    <!-- Home Section Start -->
    <div class="home">
        <div class="content">
            <h5>Welcome To World</h5>
            <h1>Visit <span class="changecontent"></span></h1>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quae, nisi.</p>
            <a href="#book">Book Place</a>
        </div>
    </div>
    <!-- Home Section End -->

    <!-- Section Reservations Start -->
    <section class="activities" id="activities">
      <div class="container">
        
        <div class="main-txt">
          <h1><span>A</span>ctivities</h1>
        </div>

       <div class="row" style="margin-top: 30px;">
    <?php
    foreach ($activities as $activity) {
        $image_url = $activity['image_url']; 
        $name = $activity['name'];   
        $description = $activity['description']; 
        $price = $activity['price']; 
    ?>
        <div class="col-md-4 py-3 py-md-0">
            <div class="flex flex-col h-[500px] bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="h-[250px] w-full">
                    <img src="<?php echo $image_url; ?>" 
                         alt="<?php echo $name; ?>"
                         class="w-full h-full object-cover" />
                </div>
                <div class="flex flex-col p-4 h-[250px] overflow-y-auto">
                    <h3 class="text-xl font-bold mb-2"><?php echo htmlspecialchars($name); ?></h3>
                    <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($description); ?></p>
                    <div class="flex mb-4">
                        <i class="fa-solid fa-star text-yellow-400"></i>
                        <i class="fa-solid fa-star text-yellow-400"></i>
                        <i class="fa-solid fa-star text-yellow-400"></i>
                        <i class="fa-solid fa-star text-gray-300"></i>
                        <i class="fa-solid fa-star text-gray-300"></i>
                    </div>
                    <form action="add_reservation.php" method="POST" class="mt-auto">
                        <input type="hidden" name="activity_id" value="<?php echo $activity['id']; ?>">
                        <input type="submit" value="Book Now" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    </form>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
</div>

      </div>
    </section>
    <!-- Section Resevations End -->

    <!-- Footer Start -->
    <footer id="footer">
      <h1><span>T</span>ravel</h1>
      <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Temporibus fugiat, ipsa quos nulla qui alias.</p>
      <div class="social-links">
        <i class="fa-brands fa-twitter"></i>
        <i class="fa-brands fa-facebook"></i>
        <i class="fa-brands fa-instagram"></i>
        <i class="fa-brands fa-youtube"></i>
        <i class="fa-brands fa-pinterest-p"></i>
      </div>
      <div class="credit">
        <p>Designed By <a href="#">SA Coding</a></p>
      </div>
      <div class="copyright">
        <p>&copy;Copyright SA Coding. All Rights Reserved</p>
      </div>
    </footer>
    <!-- Footer End -->