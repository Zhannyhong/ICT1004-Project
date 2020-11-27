<?php
// Create database connection
$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

// Check connection
if ($conn->connect_error)
{
    $errorMsg = "Connection failed: " . $conn->connect_error;
    $success = false;
    $conn->close();
}
?>

