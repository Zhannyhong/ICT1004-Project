<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["loggedin"]) && $_SESSION["loggedin"])
{
    // Create database connection
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

// Check connection
    if ($conn->connect_error)
    {
        echo "<h2>Connection failed: $conn->connect_error</h2>";
        exit();
    }

    // Need to check if this can be abused
    $reviewID = $_GET["reviewID"];

// Delete review from database
    $stmt = $conn->prepare("DELETE FROM review WHERE reviewID=?");
    $stmt->bind_param("s", $reviewID);
    $stmt->execute();

    if ($stmt->errno != 0)
        echo "<h2>Failed to delete review: $stmt->error</h2>";
    else
        // Re-direct user back to their profile page
        header("location: profile_page.php");

    $stmt->close();
    $conn->close();
}
else
{
    echo "<h2>This page is not to be run directly.</h2>";
    echo "<a href='index.php'>Go to Home page...</a>";
    exit();
}

?>
