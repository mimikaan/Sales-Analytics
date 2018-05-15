<!-- <?php
// session_start();
// require_once('dbconnect.php');
// if(!isset($_SESSION['user'])){
//     header("Location: index.php");
// }

// $userData = $db->clients->findOne(array('_id'=>$_SESSION['user']));
$username=$userData['username'];
?> -->
<?php
require_once('dbconnect.php');

$flag    = isset($_GET['flag'])?intval($_GET['flag']):0;
$message ='';
if($flag){
  $message = $messages[$flag];
}
//$filter = ['x' => ['$gt' => 1]];
// $field='';
// $fieldvalue='';
$filter =[];
//katneka start
if(isset($_POST['filter'])&&($_POST['filterfield'])){
  $field= $_POST['filterfield'];
  $fieldvalue=$_POST['filter'];
  $filter = [$field=>$fieldvalue];
}
//katneka end

$options = [
    'sort' => ['_id' => -1],
];

$query = new MongoDB\Driver\Query($filter, $options);
$cursor = $manager->executeQuery('onlinestore.orders', $query);

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
        <div class="row">
            <div class="logo">
                <h3>
                  Order History
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="span12">
                <div class="mini-layout">
                   <form id="filter" name='filter' action="order.php" method="post">
                   <input type='hidden' name='id' id='id' value="" />
                    <table>
                      <tr>
                        <td><input type='text' name='filter' id='filter' placeholder="fieldvalue" /></td>
                        <td><input type='text' name='filterfield' id='filterfield' placeholder="field" /></td>
                      </tr>
                      <tr><td>
                      <input type="submit" value="Filter">
                      </td>
                      </tr>
                    </table>
                   </form>
                    <h3>Placed Orders</h3>
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
                          <th>Username</th>
                          <th>Location</th>
                          <th>Prodcut</th>
                          <th>Category</th>
                          <th>Price</th>
                          <th>Qty</th>
                        </tr>
                     </thead>
                    <?php 
                    $total=0;
                    foreach ($cursor as $document) { ?>
                      <tr>
                        <td><?php echo $document->username; ?></td>
                        <td><?php echo $document->location;  ?></td>
                        <td><?php echo $document->product_name;  ?></td>
                        <td><?php echo $document->category;  ?></td>
                        <td><?php echo $document->price;  ?></td>
                        <td><?php echo $document->qty; ?></td>
                      </tr>
                   <?php 
                   $total=$total+($document->price*$document->qty);
                    } 
                  ?>
                  <tr>
                  <td>Total</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td><?php echo $total; ?></td>
                  </tr>
                    </table>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
$(function(){
  $('.editlink').on('click', function(){
    var id = $(this).data('id');
    if(id){
      $.ajax({
          method: "GET",
          url: "record_ajax.php",
          data: { id: id}
        })
        .done(function( result ) {
          result = $.parseJSON(result);
          $('#product_name').val(result['product_name']);
          $('#price').val(result['price']);
          $('#category').val(result['category']);
          $('#id').val(result['id']);
          $('#btn').val('Update Records');
          $('#form1').attr('action', 'record_edit.php');
        });
      }
    });
});

</script>
</body>
</html>
