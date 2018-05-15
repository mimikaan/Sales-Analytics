<?php

session_start();
require_once('dbconnect.php');

if(isset($_SESSION['user'])){
    header('Location:client.php');
}
if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['location'])) {
    $username = $_POST['username'];
    $password = hash('sha256',$_POST['password']);
	$email = $_POST['email'];
	$location = $_POST['location'];
    $result = $db->clients->insertOne(array('username'=>$username,'password'=>$password,'_id'=>$email,'location'=>$location));
    
    header('Location:index.php');  

}

?>  
<!DOCTYPE html>
<html>  
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>register</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
<div class="container">
<h1>Business App</h1>
<div class="row">
<div class="span12">
<div class="mini-layout">
<form method="post" action="register.php">
<fieldset>
<table>
<tr>
<td><label for="username">Username:</label><input type="text" name="username"/></td></tr>
<tr><td><label for="password">Password:</label><input type="password" name="password"/></td></tr>
<tr><td><label for="email">Email:</label><input type="email" name="email"/></td></tr>
<tr><td><label for="location">Location</label><input type="text" name="location"/></td></tr>
<tr><td><input type="submit" value="Sign Up"><tr><td>
</fieldset>
    </form>
    </div>
            </div >
                </div >
    <a href="index.php">Already have an account?click here</a>
    </div>
</body>
</html>