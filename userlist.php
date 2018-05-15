<?php
session_start();
require_once('dbconnect.php');
if(!isset($_SESSION['user'])){
    header("Location: adminlogin.php");
}

$userData = $db->clients->findOne(array('_id'=>$_SESSION['user']));

?>
<?php
require_once('dbconnect.php');

$flag    = isset($_GET['flag'])?intval($_GET['flag']):0;
$message ='';
if($flag){
  $message = $messages[$flag];
}
//$filter = ['x' => ['$gt' => 1]];
$filter = [];
$options = [
    'sort' => ['_id' => -1],
];

$query = new MongoDB\Driver\Query($filter, $options);
$cursor = $manager->executeQuery('onlinestore.clients', $query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Analytics</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
<?php include('adminheader.php');?>
    <div class="container">
    <h1>Business App</h1>
        <div class="row">
            <div class="logo">
                <h3>
                  Product Catalog
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="span12">
                <div class="mini-layout">
                    <h3>User Listing</h3>
                    <p>
                      <?php if($flag == 2 || $flag == 5){ ?>
                        <div class="error"><?php echo $message; ?></div>
                      <?php  } elseif($flag && $flag != 2 ){ ?>
                        <div class="success"><?php echo $message; ?></div>
                      <?php  } ?>
                    </p>
                    <table class='table table-bordered'>
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Username</th>
                          <th>Location</th>
                          <th>Email</th>
                          <th>Action</th>
                        </tr>
                     </thead>
                    <?php 
                    $i =1; 
                    foreach ($cursor as $document) { ?>
                      <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $document->username;  ?></td>
                        <td><?php echo $document->location;  ?></td>
                        <td><?php echo $document->_id;  ?></td>
                        <td> <a onClick ='return confirm("Do you want to remove this record?");' href='user_delete.php?id=<?php echo $document->_id; ?>'>Delete</a>
                            | <a href='usergraph.php?id=<?php echo $document->username; ?>'>Analyse</a>
                      </td>
                      </tr>
                   <?php $i++;  
                    } 
                  ?>
                    </table>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
</body>
</html>
