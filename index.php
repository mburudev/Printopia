<?php
// Start the session (required for remembering user login status)
session_start();

// Database connection configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "printopia";

try {
    // Connect to MySQL database using PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve form data
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];

        // Prepare and execute the SQL query to retrieve user data using placeholders to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=:username AND password=:password LIMIT 1");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        // Check if a user with the given credentials exists
        if ($stmt->rowCount() == 1) {
            // Login successful
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];

            // Redirect to respective dashboard based on user
            if ($row['user_type'] == 'admin') {
                header("Location: admin_dashboard.php");
            } elseif ($row['user_type'] == 'user') {
                header("Location: front_office_dashboard.php");
            } 
            exit();
        } else {
            // Login failed
            $error_message = "Invalid username or password.";
        }
    }
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Printopia</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
       <!-- Custom fonts for this template-->
       <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
       <link
           href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
           rel="stylesheet">
   
       <!-- Custom styles for this template-->
       <link href="css/sb-admin-2.min.css" rel="stylesheet">

       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<style>
      .row-number {
      font-weight: bold;
    }
</style>
<style>
        /* Custom styles for responsiveness */
        .search-bar {
            max-width: 100%;
        }
</style>
<style>
    .container img {
        width: 520px; /* Set your desired width */
        height: auto; /* Height will scale automatically based on the original aspect ratio */
    }
</style>
</head>

<body>

        <section>
            <div class="row m-3 p-3">

            <div class="col-8">
                <div class="container">
                    <span><img src="images/printopia_prints.jpg" class="img-fluid rounded mx-auto d-block" alt="" /></span>
                </div>
            </div>

            <div class="col-4 mt-3 pt-5 text-end">
                <div class="container mt-5">
                    <h2>PRINTOPIA PRINTS AND GRAPHICS</h2>
                    <form action="index.php" method="POST">
                        <div class="form-floating pb-4">
                            <input type="text" name="username" class="form-control" required="required" id="floatingText" placeholder="username">
                            <label for="floatingText">Username</label>
                        </div>
                        <div class="form-floating pb-4">
                            <input type="password" name="password" class="form-control" required="required" id="floatingText" placeholder="password">
                            <label for="floatingText">Password</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>

            </div>
        </section>

<!-- Modal for showing error message -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Error</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php if (isset($error_message)) echo $error_message; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to trigger the modal on login failure -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function () {
        <?php if (isset($error_message)): ?>
            $('#errorModal').modal('show');
        <?php endif; ?>
    });
</script>

</body>
</html>
