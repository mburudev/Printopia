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


    // Update the user record in the database
    $sql = "UPDATE tbl_sales SET date_out = :date_out, item = :item, item_quantity_out = :item_quantity_out, quantity_type = :quantity_type, receipt_no = :receipt_no, selling_price = :selling_price, printing_style = :printing_style, mode_of_payment = :mode_of_payment WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':date_out', $date_out);
    $stmt->bindParam(':item', $item);
    $stmt->bindParam(':item_quantity_out', $item_quantity_out);
    $stmt->bindParam(':quantity_type', $quantity_type);
    $stmt->bindParam(':receipt_no', $receipt_no);
    $stmt->bindParam(':selling_price', $selling_price);
    $stmt->bindParam(':printing_style', $printing_style);
    $stmt->bindParam(':mode_of_payment', $mode_of_payment);
    $stmt->execute();

    // Redirect to the same page to refresh the data
    header("Location:/printopia/sales_home.php");
    exit();
}

// Close the database connection
$conn = null;
?>