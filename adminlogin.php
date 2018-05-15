<?php

session_start();
require_once('dbconnect.php');

if(isset($_SESSION['user'])){
    header('Location:adminindex.php');
}
if(isset($_POST['username']) && isset($_POST['password'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $result = $db->admin->findOne(array('username'=>$username,'password'=>$password));
    if(!$result){
        header('Location:adminlogin.php');

    }else{
        $_SESSION['user'] = $result->_id; 
        header('Location:adminindex.php');  
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body><div class="container">
<h1>Business App</h1>
<div class="row">
            <div class="span12">
                <div class="mini-layout">
<form method="post" action="adminlogin.php">
<fieldset>
<label for="username">Username:</label><input type="text" name="username"/><br>
<label for="password">Password:</label><input type="password" name="password"/><br>
<input type="submit" value="Login">
</fieldset>
    </form>
    </div>
    </div>
    </div>
    <a href="register.php">[No account?register here]</a></div>
</body>
</html>