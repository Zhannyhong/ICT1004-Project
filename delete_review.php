<?php
session_start();
/* Get current_review_location, which was previously set at either 
 * movie_details.php?id=<INTEGER> or profile_page.php. */
define("PREVIOUS_LOCATION", $_SESSION['current_review_location']);

// FILTER_SANITIZE_NUMBER_INT to prevent code injection
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_SESSION["loggedin"]) && 
        $_SESSION["loggedin"] && 
        filter_input(INPUT_GET, "reviewID", FILTER_SANITIZE_NUMBER_INT))
{
    // Initialise input variables
    $movieID = $reviewID = $errorMsg = "";
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
            if (PREVIOUS_LOCATION === 'profile_page.php' || 
                    substr(PREVIOUS_LOCATION, 0, 21) === 
                    'movie_details.php?id=')
            {
                header("location: " . PREVIOUS_LOCATION);
            }
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
    require "illegal_access.php";
    echo '<a class="btn btn-danger my-4" href="index.php" role="button">Return Home</a>';
    echo "</div>";
    echo "</body>";
    include "footer.inc.php";
    exit();
}

?>
