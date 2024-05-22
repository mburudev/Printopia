<?php
session_start();
error_reporting();
include('../../config/configpdo.php');
	
if(isset($_POST['submit']))
{
$date_in=$_POST['date_in'];
$inventory_item=$_POST['inventory_item'];
$item_quantity=$_POST['item_quantity'];
$quantity_type=$_POST['quantity_type'];
$buying_price=$_POST['buying_price'];
$category_id=$_POST['category_id'];


$sql="INSERT INTO  inventory(date_in, inventory_item, item_quantity, quantity_type, buying_price, category_id) VALUES(:date_in, :inventory_item, :item_quantity, :quantity_type, :buying_price, :category_id)";
$query = $dbh->prepare($sql);
$query->bindParam(':date_in',$date_in,PDO::PARAM_STR);
$query->bindParam(':inventory_item',$inventory_item,PDO::PARAM_STR);
$query->bindParam(':item_quantity',$item_quantity,PDO::PARAM_STR);
$query->bindParam(':quantity_type',$quantity_type,PDO::PARAM_STR);
$query->bindParam(':buying_price',$buying_price,PDO::PARAM_STR);
$query->bindParam(':category_id',$category_id,PDO::PARAM_STR);

$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
header(("location: ../../inventory_home.php"));
}
else 
{
$error="Something went wrong. Please try again";
}

}




// Fetch data from the MySQL table
$query = "SELECT id, option_name FROM options_table";
$stmt = $pdo->prepare($query);
$stmt->execute();

// Populate the select field with options
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '<option value="' . $row['id'] . '">' . $row['option_name'] . '</option>';
}


?>