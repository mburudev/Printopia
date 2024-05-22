<?php
session_start();
error_reporting();
include('../../config/configpdo.php');
	
if(isset($_POST['submit']))
{
$category_name=$_POST['category_name'];


$sql="INSERT INTO  tbl_category(category_name) VALUES(:category_name)";
$query = $dbh->prepare($sql);
$query->bindParam(':category_name',$category_name,PDO::PARAM_STR);

$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
header(("location: ../../product_categories_home.php"));
}
else 
{
$error="Something went wrong. Please try again";
}

}
?>