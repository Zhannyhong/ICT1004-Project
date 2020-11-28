<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"])
    {
        // Initialise input variables
        $rating = $review_title = $review_writeup = "";
        $userID = $_SESSION["userID"];
        $success = true;

        // ensure rating is not empty
        if (empty($_POST["rating"]))
        {
            $errorMsg .= "A rating is required.<br>";
            $success = false;
        }
        else
        {
            $rating = $_POST["rating"];
        }

        // Ensure title and writeup not empty and sanitise
        if (empty($_POST["review_title"]) || empty($_POST["review_writeup"])) 
        {
            $errorMsg .= "A review title and message is required.<br>";
            $success = false;
        }
        else
        {
            $review_title = sanitize_input($_POST["review_title"]);
            $review_writeup = sanitize_input($_POST["review_writeup"]);
        }

        if ($success)
        {
            $movieID = $_POST["movieID"];
            saveReviewToDB();
        }

        unset($rating);
        unset($review_title);
        unset($review_writeup);
    }
    else
    {
        echo "<h2>You must be logged in to submit a review.</h2>";
        echo "<p>You can login at the link below:</p>";
        echo "<a href='login.php'>Go to Login page...</a>";
        exit();
    }
}
else
{
    echo "<h2>This page is not to be run directly.</h2>";
    echo "<p>You can register at the link below:</p>";
    echo "<a href='login.php'>Go to Login page...</a>";
    exit();
}

//Helper function that checks input for malicious or unwanted content.
function sanitize_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Helper function that saves review to DB
function saveReviewToDB()
{
    global $rating, $review_title, $review_writeup, $userID, $movieID, $success;
    require_once "connect_database.php";
    // Get current datetime in UNIX format
    date_default_timezone_set('Asia/Singapore');
    $curr_datetime = date('Y-m-d H:i:s');

    // Saves new user to database
    $stmt = $conn->prepare("INSERT INTO reviews (movieID, userID, reviewRating, reviewTitle, writeup, reviewDate) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $movieID, $userID, $rating, $review_title, $review_writeup, $curr_datetime);
    require "handle_sql_execute_failure.php";
    
}
?>

<html lang="en">
    <head>
        <title>Review Submission Results</title>
        <?php
            include "head.inc.php";
        ?>
    </head>
    <body>    
        <?php
            include "nav.inc.php";
        ?>
        <main class="container">
            <hr/>
            <?php
            if ($success)
            {
                echo "<h1 class='display-4'>Review Submission successful</h1>";
                echo "<h5>Thank you for submitting your review</h5>";
                echo '<a class="btn btn-success mb-3" href="movie_template.php?id=' . $movieID . '" role="button">Return to Movie</a>';
            }
            else
            {
                echo "<h1 class='display-4'>Oops!</h1>";
                echo "<h3>The following errors were detected:</h3>";
                echo "<p class='text-secondary'>" . $errorMsg . "</p>";
                echo '<a class="btn btn-danger mb-3" href="movie_template.php?id=' . $movieID . '" role="button">Return to Home</a>';
            }
            ?>
        </main>
        <?php
            unset($movieID);
            unset($success);
            unset($errorMsg);
            include "footer.inc.php";
        ?>
    </body>
</html>