<?php
session_start();

// FILTER_SANITIZE_NUMBER_INT to prevent code injection
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] && filter_input(INPUT_GET, "reviewID", FILTER_SANITIZE_NUMBER_INT))
{
    // Initialise input variables
    $reviewID = $errorMsg = "";
    $success = true;

    require "connect_database.php";

    if ($success)
    {
        // FILTER_SANITIZE_NUMBER_INT to prevent code injection
        $reviewID = filter_input(INPUT_GET, "reviewID", FILTER_SANITIZE_NUMBER_INT);

        // Delete review from database
        $stmt = $conn->prepare("DELETE FROM reviews WHERE reviewID=?");
        $stmt->bind_param("s", $reviewID);
        $stmt->execute();

        if ($stmt->affected_rows == 1)
        {
            // Successful deletion, re-directing user back to their profile page
            $stmt->close();
            $conn->close();
            header("location: profile_page.php");
        }
        else
        {
            echo "<h2>Failed to delete review: (' . $stmt->errno . ') ' . $stmt->error</h2>";
        }
    }

    $stmt->close();
    $conn->close();
    unset($reviewID, $errorMsg, $success);
}
else
{
    echo "<h2>This page is not to be run directly.</h2>";
    echo "<a href='index.php'>Go to Home page...</a>";
    exit();
}

?>
