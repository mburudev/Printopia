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
$sql = "SELECT * FROM inventory";
$result = $conn->query($sql);

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inventory_id = $_POST["inventory_id"];
    $date_in = $_POST["date_in"];
    $inventory_item = $_POST["inventory_item"];
    $item_quantity = $_POST["item_quantity"];
    $quantity_type = $_POST["quantity_type"];
    $buying_price = $_POST["buying_price"];


    // Update the user record in the database
    $sql = "UPDATE inventory SET date_in = :date_in, inventory_item = :inventory_item, item_quantity = :item_quantity, quantity_type = :quantity_type, buying_price = :buying_price WHERE inventory_id = :inventory_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':date_in', $date_in);
    $stmt->bindParam(':inventory_item', $inventory_item);
    $stmt->bindParam(':item_quantity', $item_quantity);
    $stmt->bindParam(':quantity_type', $quantity_type);
    $stmt->bindParam(':buying_price', $buying_price);
    $stmt->bindParam(':inventory_id', $inventory_id);
    $stmt->execute();

    // Redirect to the same page to refresh the data
    header("Location:/printopia/inventory_home.php");
    exit();
}

// Close the database connection
$conn = null;
?>