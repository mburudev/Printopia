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
$sql = "SELECT * FROM tbl_sales";
$result = $conn->query($sql);

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $date_out = $_POST["date_out"];
    $item = $_POST["item"];
    $item_quantity_out = $_POST["item_quantity_out"];
    $quantity_type = $_POST["quantity_type"];
    $receipt_no = $_POST["receipt_no"];
    $selling_price = $_POST["selling_price"];
    $printing_style = $_POST["printing_style"];
    $mode_of_payment = $_POST["mode_of_payment"];

    // Delete the user record in the database
    $sql = "DELETE FROM tbl_sales WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Redirect to the same page to refresh the data
    header("Location:/printopia/sales_home.php");
    exit();
}

// Close the database connection
$conn = null;
?>