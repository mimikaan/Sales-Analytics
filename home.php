<?php
session_start();
require_once('dbconnect.php');
if(!isset($_SESSION['user'])){
    header("Location: index.php");
}

$userData = $db->clients->findOne(array('_id'=>$_SESSION['user']));

?>
<html>
<head>
<title>Home</title>
<head>
<body>
<?php include('header.php');?>
<form method="post" action="create_tweet.php">
    <fieldset
    <label for="tweet">What's happpening?</label><br>
    <textarea name="body" rows="4" cols="50"></textarea><br>
    <input type="submit" value="Tweet" />
    </fieldset>
</form>
</body>
</html>