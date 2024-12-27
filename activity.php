<?php class Activity {
   private $name;
   private $description;
   private $type;
   private $location;
   private $price;
   private $availability_status;
   private $image_url;
   protected $dbcon;

   public function __construct($db, $name = "", $description = "", $type = "", $location = "", $price = "", $availability_status = "", $image_url = "") {
       $this->dbcon = $db;
       $this->name = $name;
       $this->description = $description;
       $this->type = $type;
       $this->location = $location;
       $this->price = $price;
       $this->availability_status = $availability_status;
       $this->image_url = $image_url;
   }

   public function insertActivity() {
       try {
           $sql = "INSERT INTO Activities(name, description, type, location, price, availability_status, image_url)
                   VALUES (:name, :description, :type, :location, :price, :availability_status, :image_url)";
           $stmt = $this->dbcon->prepare($sql);

           $stmt->bindParam(':name', $this->name);
           $stmt->bindParam(':description', $this->description);
           $stmt->bindParam(':type', $this->type);
           $stmt->bindParam(':location', $this->location);
           $stmt->bindParam(':price', $this->price);
           $stmt->bindParam(':availability_status', $this->availability_status);
           $stmt->bindParam(':image_url', $this->image_url);

           $stmt->execute();
           return true;
       } catch (PDOException $e) {
           return "Error: " . $e->getMessage();
       }
   }

   public function getActivities() {
       try {
           $sql = "SELECT * FROM Activities";
           $stmt = $this->dbcon->prepare($sql);
           $stmt->execute();
           return $stmt->fetchAll(PDO::FETCH_ASSOC);
       } catch (PDOException $e) {
           return "Error: " . $e->getMessage();
       }
   }

   public function deleteActivity($id) {
       try {
           $sql = "DELETE FROM Activities WHERE id = :id";
           $stmt = $this->dbcon->prepare($sql);
           $stmt->bindParam(':id', $id);
           return $stmt->execute();
       } catch (PDOException $e) {
           return false;
       }
   }

   public function updateActivity($id, $name, $description, $type, $location, $price, $status) {
       try {
           $sql = "UPDATE Activities SET name=:name, description=:description, type=:type, 
                   location=:location, price=:price, availability_status=:status 
                   WHERE id=:id";
           $stmt = $this->dbcon->prepare($sql);
           $stmt->execute([
               ':id' => $id,
               ':name' => $name,
               ':description' => $description,
               ':type' => $type,
               ':location' => $location,
               ':price' => $price,
               ':status' => $status
           ]);
           return true;
       } catch (PDOException $e) {
           return false;
       }
   }
}

$db = new Database();
$conn = $db->connect();

// Handle delete
if(isset($_POST['delete_id'])) {
    $activity = new Activity($conn);
    if($activity->deleteActivity($_POST['delete_id'])) {
        echo "<script>alert('Activity deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting activity!');</script>";
    }
}

if (!$conn) {
    die("Database connection failed. Please try again later.");
}

// Handle edit form submission
if(isset($_POST['update'])) {
    $id = $_POST['edit_id'];
    $name = $_POST['edit_name'];
    $description = $_POST['edit_description'];
    $type = $_POST['edit_type'];
    $location = $_POST['edit_location'];
    $price = $_POST['edit_price'];
    $status = $_POST['edit_status'];
    
    $activity = new Activity($conn);
    if($activity->updateActivity($id, $name, $description, $type, $location, $price, $status)) {
        echo "<script>alert('Activity updated successfully!'); window.location.href='activities.php';</script>";
    } else {
        echo "<script>alert('Error updating activity!');</script>";
    }
}

// Insert Activity Logic
if (isset($_POST['submit'])) {
   $name = $_POST['name'];
   $description = $_POST['description'];
   $type = $_POST['type'];
   $location = $_POST['location'];
   $price = $_POST['price'];
   $availability_status = $_POST['availability_status'];

   // File upload handling
   $image_url = "";
   if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == 0) {
       $target_dir = "uploads/";
       $file_type = pathinfo($_FILES["image_url"]["name"], PATHINFO_EXTENSION);
       $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

       if (in_array($file_type, $allowed_types)) {
           $target_file = $target_dir . uniqid() . "." . $file_type;
           move_uploaded_file($_FILES["image_url"]["tmp_name"], $target_file);
           $image_url = $target_file;
       } else {
           echo "<script>alert('Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.');</script>";
           exit;
       }
   }

   // Validation
   if (empty($name) || empty($type) || empty($price)) {
       echo "<script>alert('Name, type, and price are required!');</script>";
   } else {
       $activity = new Activity($conn, $name, $description, $type, $location, $price, $availability_status, $image_url);
       $result = $activity->insertActivity();

       if ($result === true) {
           echo "<script>alert('Activity added successfully!');</script>";
       } else {
           echo "<script>alert('Error: " . addslashes($result) . "');</script>";
       }
   }
}