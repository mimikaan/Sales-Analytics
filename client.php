<?php
session_start();
require_once('dbconnect.php');
if(!isset($_SESSION['user'])){
    header("Location: index.php");
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
$cursor = $manager->executeQuery('onlinestore.products', $query);

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
<?php include('header.php');?>
    <div class="container">
    <h1>Business App</h1>
        <div class="row">
            <div class="logo">
                <h3>
                  Place Order
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="span12">
                <div class="mini-layout">
                   <form id="form2" name='form2' action="record_add2.php" method="post">
                   <input type='hidden' name='id' id='id' value="" />
                    <table>
						
						
                      <tr>
                        <td><input type='text' name='product_name' id='product_name' placeholder="Product Name"  readonly/></td>
                        <td><input type='text' name='price' id='price' placeholder="Price" readonly /></td>
                        <td><input type='text' name='category' id='category' placeholder="Category" readonly/></td>
                        <td><input type='text' name='qty' id='qty' placeholder="Qty" /></td>
                      </tr>
                      <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                      <td align="right"><input class='btn' type='submit' name='btn' id='btn' value="Place Order" /></td>
                      </tr>
                    </table>
                   </form>
                    <h3>Products Listing</h3>
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
                          <th>Prodcut</th>
                          <th>Price</th>
                          <th>Category</th>
                          <th>Action</th>
                        </tr>
                     </thead>
                    <?php 
                    $i =1; 
                    foreach ($cursor as $document) { ?>
                      <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $document->product_name;  ?></td>
                        <td><?php echo $document->price;  ?></td>
                        <td><?php echo $document->category;  ?></td>
                        <td><a class='editlink' data-id=<?php echo $document->_id; ?> href='javascript:void(0)'>Order</a> </td>
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
          $('#btn').val('Place Order');
          $('#form2').attr('action', 'record_add2.php');
        });
      }
    });
});

</script>
</body>
</html>
