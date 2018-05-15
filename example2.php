<?php
header('Content-Type: application/json');
require_once('dbconnect.php');
$cursor= $db->clients->distinct('location');
$locationarr=array();
$i=0;
foreach($cursor as $c){
        $result=$db->orders->find(array('location'=>$c));
        $total=0;
        foreach($result as $r){
                $total=$total+$r->qty;
        }
        $locationarr[$i]['location']=$c;
        $locationarr[$i]['total']=$total;
        $i++;
}
print json_encode($locationarr);

?>


