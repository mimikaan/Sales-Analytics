<?php
	session_start();
	require_once('dbconnect.php');
	if(!isset($_SESSION['user'])){
    header("Location: index.php");
}

	$userData = $db->clients->findOne(array('_id'=>$_SESSION['user']));
  $product_name = '';
  $price        = 0;
  $category     = '';
  $qty          = 0;
  $flag         = 0;
  $user_name =$userData['username'];
  $user_location= $userData['location'];
  if(isset($_POST['btn'])){
	 
      $product_name = $_POST['product_name'];
      $price        = $_POST['price'];
      $qty          = $_POST['qty'];   
      $category     = $_POST['category'];
		

      if(!$product_name || !$price || !$category || !$qty){
        $flag = 5;
      }else{
          $insRec       = new MongoDB\Driver\BulkWrite;
          $insRec->insert(['username'=>$user_name,'product_name' =>$product_name, 'price'=>$price, 'category'=>$category ,'qty'=>$qty,'location'=>$user_location]);
          $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
          $result       = $manager->executeBulkWrite('onlinestore.orders', $insRec, $writeConcern);

          if($result->getInsertedCount()){
            $flag = 3;
          }else{
            $flag = 2;
          }
      }
  }
  header("Location: client.php?flag=$flag");
  exit;
