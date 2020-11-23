<?php
session_start();

unset($_SESSION["userID"]);
$_SESSION["loggedin"] = false;

header("Location:index.php");

?>

