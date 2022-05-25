<?php 

error_reporting(E_ALL);

session_start();
$sessid = session_id();
$total = 0;

//Database connection
$dbh = new PDO("mysql:host=localhost;dbname=kopchaijerky", "root", "root");
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//get action string
$action = isset($_GET['action'])?$_GET['action']:"";

//get cart items
$getcart = $dbh->prepare("select products.name, products.product_id, products.price, cartitems.qty
from products, cartitems
where cartitems.productid = products.product_id and cartitems.sessionid = '$sessid'");

$getcart->execute();
$getcartrow = $getcart->fetch();
$qty = $getcartrow['qty'] ?? 0;


//Add to cart
if($action=='addcart' && $_SERVER['REQUEST_METHOD']=='POST') {
	
  $qty = $_POST['qty'];

	//Finding the product by code
	$query = "SELECT * FROM products WHERE sku=:sku";
	$stmt = $dbh->prepare($query);
	$stmt->bindParam('sku', $_POST['sku']);
	$stmt->execute();
	$product = $stmt->fetch();

  $productid = $product['product_id'];


  //check the cartitem table to see if sku is in there
  $chkquery = "SELECT * FROM cartitems WHERE productid = '$productid' and sessionid = '$sessid'";
  $chkstmt = $dbh->prepare($chkquery);
  $chkstmt->execute();
  $productincart = $chkstmt->fetch();
  $id = $productincart['id'];
  if (!empty($id)){
    $upstmt = $dbh->prepare("update cartitems set qty = '$qty' where productid = '$productid' and sessionid = '$sessid'");
    $upstmt->execute();
  }
  else {
    $instmt = $dbh->prepare("insert into cartitems (productid,sessionid,timeofentry,qty) values ('$productid','$sessid',now(),'$qty')");
    $instmt->execute();

  }
  //if it is, we'll write an update statement


  //else write an insert statement

	
	$currentQty = $_POST['qty']; //Incrementing the product qty in cart
	$_SESSION['products'][$_POST['sku']] =array('qty'=>$currentQty,'name'=>$product['name'],'image'=>$product['image'],'price'=>$product['price']);
	$product='';
	header('Location:index.php');
}
 
 //Get all Products
$query = "SELECT * FROM products";
$stmt = $dbh->prepare($query);
$stmt->execute();
$products = $stmt->fetchAll();


?>