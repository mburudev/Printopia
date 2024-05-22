<?php
session_start();
error_reporting();
include('../../config/configpdo.php');
	
if(isset($_POST['submit']))
{
$cid=$_POST['cid'];
$date_out=$_POST['date_out'];
$receipt_no=$_POST['receipt_no'];
$item=$_POST['item'];
$item_quantity_out=$_POST['item_quantity_out'];
$quantity_type=$_POST['quantity_type'];
$selling_price=$_POST['selling_price'];
$printing_style=$_POST['printing_style'];
$mode_of_payment=$_POST['mode_of_payment'];


$sql="INSERT INTO  tbl_sales(cid, date_out, receipt_no, item, item_quantity_out, quantity_type, selling_price, printing_style, mode_of_payment) VALUES(:cid, :date_out, :receipt_no, :item, :item_quantity_out, :quantity_type, :selling_price, :printing_style, :mode_of_payment)";
$query = $dbh->prepare($sql);
$query->bindParam(':cid',$cid,PDO::PARAM_STR);
$query->bindParam(':date_out',$date_out,PDO::PARAM_STR);
$query->bindParam(':receipt_no',$receipt_no,PDO::PARAM_STR);
$query->bindParam(':item',$item,PDO::PARAM_STR);
$query->bindParam(':item_quantity_out',$item_quantity_out,PDO::PARAM_STR);
$query->bindParam(':quantity_type',$quantity_type,PDO::PARAM_STR);
$query->bindParam(':selling_price',$selling_price,PDO::PARAM_STR);
$query->bindParam(':printing_style',$printing_style,PDO::PARAM_STR);
$query->bindParam(':mode_of_payment',$mode_of_payment,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
header(("location: ../../sales_home.php"));
}
else 
{
$error="Something went wrong. Please try again";
}

}

?>