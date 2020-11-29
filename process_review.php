<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"])
    {
        // Initialise input variables
        $rating = $review_title = $review_writeup = $errorMsg = $movieID = $reviewID = "";
        $userID = $_SESSION["userID"];
        $success = true;

        // ensure rating is not empty
        if (empty($_POST["rating"]))
        {
            $intent = $_POST["intent"];
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
            $reviewID = $_POST["reviewID"];
            $intent = $_POST["intent"];
            saveReviewToDB();
        }

        unset($rating, $reviewID, $review_title, $review_writeup, $userID);
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
    global $rating, $review_title, $review_writeup, $userID, $movieID, $reviewID, $intent, $success, $errorMsg;
    require "connect_database.php";
    // Get current datetime in UNIX format
    date_default_timezone_set('Asia/Singapore');
    $curr_datetime = date('Y-m-d H:i:s');
    
    if ($intent == "posted") {
        // Saves new review to database
        $stmt = $conn->prepare("INSERT INTO reviews (movieID, userID, reviewRating, reviewTitle, writeup, reviewDate) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $movieID, $userID, $rating, $review_title, $review_writeup, $curr_datetime);
        require "handle_sql_execute_failure.php";
    } elseif ($intent == "updated") {
        // Updates review to database
        $stmt = $conn->prepare("UPDATE reviews
                                SET reviewRating=?, reviewTitle=?, writeUp=?, reviewDate=?
                                WHERE reviewID=?");
        $stmt->bind_param("sssss", $rating, $review_title, $review_writeup, $curr_datetime, $reviewID);
        require "handle_sql_execute_failure.php";   
    }
    else
    {
        $success = false;
        $errorMsg .= "This review could not be processed.";
    }
    $conn->close();
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
                if ($intent == "posted")
                {
                    echo "<h1 class='display-4'>Review Submission successful</h1>";
                    echo "<h5>Thank you, your review has been " . $intent . ".</h5>";
                    echo '<a class="btn btn-success mb-3" href="movie_template.php?id=' . $movieID . '" role="button">Return to Movie</a>';
                }
                else if ($intent == "updated")
                {
                    echo "<h1 class='display-4'>Review Updated successfully</h1>";
                    echo "<h5>Thank you, your review has been " . $intent . ".</h5>";
                    echo '<a class="btn btn-success mb-3" href="profile_page.php" role="button">Return to Profile Page</a>';
                }
            }
            else
            {
                if ($intent == "posted")
                {
                    echo "<h1 class='display-4'>Oops!</h1>";
                    echo "<h3>The following errors were detected:</h3>";
                    echo "<p class='text-secondary'>" . $errorMsg . "</p>";
                    echo '<a class="btn btn-danger mb-3" href="movie_template.php?id=' . $movieID . '" role="button">Return to Home</a>';
                }
                else if ($intent == "updated")
                {
                    echo "<h1 class='display-4'>Oops!</h1>";
                    echo "<h3>The following errors were detected:</h3>";
                    echo "<p class='text-secondary'>" . $errorMsg . "</p>";
                    echo '<a class="btn btn-danger mb-3" href="profile_page.php" role="button">Return to Profile page</a>';
                }
            }
            ?>
        </main>
        <?php
            unset($movieID, $errorMsg, $intent, $success);
            include "footer.inc.php";
        ?>
    </body>
</html>