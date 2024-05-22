<?php

error_reporting ();

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "printopia";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Fetch user data from the database
$sql = "SELECT * FROM tbl_category";
$result = $conn->query($sql);

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $category_name = $_POST["category_name"];


    // Update the user record in the database
    $sql = "UPDATE tbl_category SET category_name=:category_name WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':category_name', $category_name);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Redirect to the same page to refresh the data
    header("Location:/printopia/product_categories_home.php");
    exit();
}

// Close the database connection
$conn = null;
?>