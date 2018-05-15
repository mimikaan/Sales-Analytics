<?php
require 'vendor/autoload.php';
$client = new MongoDB\Client('mongodb://pritom:hello@ds121589.mlab.com:21589/onlinestore');
$db = $client->onlinestore;
?>
<?php
ini_set('display_errors','true');
error_reporting(E_ALL);

$messages = array(
	1=>'Record deleted successfully',
	2=>'Error occured. Please try again.', 
	3=>'Record saved successfully.',
    4=>'Record updated successfully.', 
    5=>'All fields are required.' );


$mongoDbname  =  'onlinestore';
$mongoTblName =  'products';
$mongoTblOrder = 'orders';
$mongoTblRegister = 'clients';
$manager     = new MongoDB\Driver\Manager("mongodb://pritom:hello@ds121589.mlab.com:21589/onlinestore");
?>
