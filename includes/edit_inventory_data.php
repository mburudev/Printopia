<?php
// includes/edit_inventory_data.php

include('../config/config.php');

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["inventory_id"])) {
    $inventory_id = $_GET["inventory_id"];
    
    // Fetch the inventory data by ID from the database
    $sql = "SELECT * FROM inventory WHERE inventory_id = :inventory_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':inventory_id', $inventory_id);
    $stmt->execute();
    
    // Fetch the result as an associative array
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Return the data as JSON
    header('Content-Type: application/json');
    echo json_encode($result);
} else {
    // Handle invalid or missing parameters
    echo json_encode(array('error' => 'Invalid request'));
}
?>
