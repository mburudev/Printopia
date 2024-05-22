<?php
$host = 'localhost';
$dbname = 'printopia';
$username = 'root';
$password = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$query = "SELECT * FROM tbl_category"; // Change this query accordingly
$stmt = $db->query($query);
$options = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($options as $option) {
    echo "<option value=\"{$option['id']}\">{$option['category_name']}</option>";
}
?>