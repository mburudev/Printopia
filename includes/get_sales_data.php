<?php
// Include your database configuration
include('../config/config.php');

if (isset($_GET['category'])) {
    $category = $_GET['category'];

    try {
        // Prepare and execute the SQL query to fetch sales data for the selected category
        $sql = "SELECT tbl_category.category_name, tbl_sales.date_out, tbl_sales.item, tbl_sales.item_quantity_out, tbl_sales.quantity_type, tbl_sales.selling_price, (tbl_sales.selling_price * tbl_sales.item_quantity_out) AS total_selling_price, tbl_sales.printing_style, tbl_sales.mode_of_payment 
                FROM tbl_category JOIN tbl_sales ON tbl_category.id = tbl_sales.cid
                WHERE category_name = :category";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':category', $category);
        $stmt->execute();

        // Fetch the results and return as JSON
        $salesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($salesData);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode([]);
}
?>
