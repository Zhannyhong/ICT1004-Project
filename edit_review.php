<?php
session_start();
$reviewRating = $reviewTitle = $writeUp = $userID = "";
$success = true;

// FILTER_SANITIZE_NUMBER_INT to prevent code injection
if ($_SERVER["REQUEST_METHOD"] == "GET" && filter_input(INPUT_GET, "reviewID", FILTER_SANITIZE_NUMBER_INT) && isset($_SESSION["loggedin"]) && $_SESSION["loggedin"])
{
    $reviewID = filter_input(INPUT_GET, "reviewID", FILTER_SANITIZE_NUMBER_INT);
    $userID = $_SESSION["userID"];
    fetchReviewData();
} else 
{
    $success = false;
    $errorMsg = "This link can only be reached via a logged-in user editing of a review.";
}


function fetchReviewData(){
    global $reviewID, $reviewRating, $reviewTitle, $writeUp, $userID, $errorMsg, $success;
    
    
    require "connect_database.php";

    if ($success)
    {
        $stmt = $conn->prepare("SELECT * FROM reviews WHERE reviewID=?");
        $stmt->bind_param("s", $reviewID);
        require "handle_sql_execute_failure.php";
        
        if ($result->num_rows == 1)
        {
            $row = $result->fetch_assoc();
            
            // check if user logged in is accessing own review
            if ($userID != $row["userID"])
            {
                $success = false;
                $errorMsg = "This is not your review.";
            }
            else
            {
                // get review info
                $reviewRating = $row["reviewRating"];
                $reviewTitle = $row["reviewTitle"];
                $writeUp = $row["writeUp"];
            }
        }
        else
        {
            $success = false;
            $errorMsg = "The review could not be found.";
        }
        $stmt->close();
        $conn->close();
    }
}
?>


<html lang="en">
    <head>
        <?php
            include "head.inc.php";
        ?>
        <link rel="stylesheet" href="css/movie_template.css">
        <!-- Custom JS -->
        <script defer src="js/movie_template.js"></script>
        <title>Edit Review</title>
    </head>
    <body>
        <?php
        include "nav.inc.php";
        ?>
        <main class="container">
            <?php
                if ($success)
                {
            ?>
            <h1 class="display-4 mt-4">Edit Review</h1>
            <hr>
            <div id="leave-review">
                <form action="process_review.php" method="post">
                    <div class="form-group rating star-rating">
                        <input type="hidden" name="reviewID" id="reviewID"
                               value="<?=$reviewID?>">
                        <input type="hidden" name="intent" id="intent" value="updated">
                        <input type="hidden" name="rating" id="rating">
                        <!-- Unusual format to remove whitespaces
                        between stars -->
                        <span data-score="1">★</span
                        ><span data-score="2">★</span
                        ><span data-score="3">★</span
                        ><span data-score="4">★</span
                        ><span data-score="5">★</span>
                    </div>
                    <div class="form-group">
                        <label class="visually-hidden" for="review_title">Title</label>
                        <input required class="form-control col-5" type="text" placeholder="Enter title" id="review_title" name="review_title" maxlength="50" value="<?=$reviewTitle?>">
                    </div>
                    <div class="form-group">
                        <label class="visually-hidden" for="review_writeup">Message</label>
                        <textarea required class="form-control" rows="2" placeholder="Enter your review here" id="review_writeup" name="review_writeup"><?=$writeUp?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Update review</button>
                </form>
            </div>
            <?php
                } else
                    {
                        echo "<h1 class='display-4'>Oops!</h1>";
                        echo "<h3>The following input errors were detected:</h3>";
                        echo "<p class='text-secondary'>" . $errorMsg . "</p>";
                        echo '<a class="btn btn-danger mb-3" href="profile_page.php" role="button">Return to Profile Page</a>';
                    }
            ?>
        </main>
        <?php
            include "footer.inc.php";
            unset($errorMsg, $reviewID, $reviewRating, $reviewTitle, $success, $userID, $writeUp);
        ?>
    </body>
</html>