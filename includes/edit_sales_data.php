<?php
// includes/edit_sales_data.php

include('../config/config.php');

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];
    
    // Fetch the sales data by ID from the database
    $sql = "SELECT * FROM tbl_sales WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
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

