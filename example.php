<?php
header('Content-Type: application/json');
require_once('dbconnect.php');
$count = $db->products->count();
$cursor = $db->products->find();
$arrr = array();

$i=0;
foreach($cursor as $document){
       
        $filter = $document->product_name;
        $query = $db->orders->find(array('product_name'=>$filter));
        $total=0;
        foreach($query as $r){
                $total = $total + $r->qty;
        }
        
        $arrr[$i]['product_name']=$filter;
        $arrr[$i]['total']=$total;
        $i++;        
    }
    print json_encode($arrr);
?>


