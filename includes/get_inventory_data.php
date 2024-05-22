<?php
// Include your database configuration
include('../config/config.php');

if (isset($_GET['category'])) {
    $category = $_GET['category'];

    try {
        // Prepare and execute the SQL query to fetch sales data for the selected category
        $sql = "SELECT tbl_category.category_name, inventory.date_in, inventory.inventory_item, inventory.item_quantity, inventory.buying_price, inventory.quantity_type, (inventory.buying_price * inventory.item_quantity) AS total_buying_price, inventory.inventory_id
                FROM tbl_category JOIN inventory ON tbl_category.id = inventory.category_id
                WHERE category_name = :category";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':category', $category);
        $stmt->execute();

        // Fetch the results and return as JSON
        $salesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Output the data as JSON
        echo json_encode($salesData);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode([]);
}
?>
