<?php
header('Content-Type: application/json');
require_once('dbconnect.php');
$cursor= $db->products->distinct('product_name');
$username=$_GET['name'];
$locationarr=array();
$i=0;
foreach($cursor as $c){
        $result=$db->orders->find(array('product_name'=>$c, 'username'=>$username));
        $total=0;
        foreach($result as $r){
                $total=$total+$r->qty;
        }
        $locationarr[$i]['product_name']=$c;
        $locationarr[$i]['total']=$total;
        $i++;
}
print json_encode($locationarr);
?>
