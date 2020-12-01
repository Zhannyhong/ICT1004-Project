<?php
session_start();

$movieTitle = $description = $genre = $director = $producer = $actors = $length = $releaseDate = $maturityRating = $poster_landscape = $userID = $errorMsg = "";
$review_count = $average_rating = $fiveStarPercent = $fourStarPercent = $threeStarPercent = $twoStarPercent = $oneStarPercent = "";
$reviewRatingArr = $reviewTitleArr = $writeupArr = $reviewDateArr = $usernameArr = $profilePicArr = $userIDArr = $reviewIDArr = array();
$success = true;

// FILTER_SANITIZE_NUMBER_INT to prevent code injection
if ($_SERVER["REQUEST_METHOD"] == "GET" && filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT))
{
    $movieID = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
    fetchMovieData();
} else 
{
    $success = false;
    $errorMsg = "No movie selected.";
}

// helper function to count number of occurrences for a value in an array
function countOccurrencesInArr($array, $value){
    $counter = 0;
    // go through each value in array
    foreach($array as $valueInArr) 
    {
        if($valueInArr === $value){ 
        $counter++; 
        }
    }
    return $counter;
}

//Helper function to fetch movie data.
function fetchMovieData()
{
    global $movieID, $movieTitle, $description, $genre, $director, $producer, $actors, $length, $releaseDate, $maturityRating, $poster_landscape, $errorMsg, $success;
    global $review_count, $average_rating, $reviewRatingArr, $reviewTitleArr, $writeupArr, $reviewDateArr, $usernameArr, $profilePicArr, $userIDArr, $reviewIDArr;
    global $fiveStarPercent, $fourStarPercent, $threeStarPercent, $twoStarPercent, $oneStarPercent;

    require "connect_database.php";

    if ($success)
    {
        $stmt = $conn->prepare("SELECT * FROM movies WHERE movieID=?");
        $stmt->bind_param("s", $movieID);
        require "handle_sql_execute_failure.php";

        if ($result->num_rows == 1)
        {
            $row = $result->fetch_assoc();
            $movieID = $row["movieID"];
            $movieTitle = $row["movieTitle"];
            $description = $row["description"];
            $genre = $row["genre"];
            $director = $row["director"];
            $producer = $row["producer"];
            $actors = $row["actors"];
            $length = $row["length"];
            $releaseDate = $row["releaseDate"];
            $maturityRating = $row["maturityRating"];
            $poster_landscape = $row["poster_landscape"];
            
            // query database again for review and user data
            $stmt = $conn->prepare("SELECT U.username, U.profilePic, R.userID, R.reviewID, R.reviewRating, R.reviewTitle, R.writeUp, R.reviewDate
                                    FROM users U, reviews R
                                    WHERE R.userID = U.userID AND R.movieID = ?
                                    ORDER BY R.reviewDate DESC");
            $stmt->bind_param("s", $movieID);
            require "handle_sql_execute_failure.php";
            $review_count = $result->num_rows;
            
            while ($row = $result->fetch_assoc()) {
                array_push($userIDArr, $row['userID']);
                array_push($reviewIDArr, $row['reviewID']);
                array_push($reviewRatingArr, $row['reviewRating']);
                array_push($reviewTitleArr, $row['reviewTitle']);
                array_push($writeupArr, $row['writeUp']);
                array_push($reviewDateArr, $row['reviewDate']);
                array_push($usernameArr, $row['username']);
                array_push($profilePicArr, $row['profilePic']);
            }
            
            // calculate average rating for movie and round off to 1dp
            $average_rating = round(array_sum($reviewRatingArr) / count($reviewRatingArr), 1);
 
            // calculate percentages for each rating user gives and round off to 1dp
            $fiveStarPercent = round(countOccurrencesInArr($reviewRatingArr, 5) / count($reviewRatingArr) * 100, 1);
            $fourStarPercent = round(countOccurrencesInArr($reviewRatingArr, 4) / count($reviewRatingArr) * 100, 1);
            $threeStarPercent = round(countOccurrencesInArr($reviewRatingArr, 3) / count($reviewRatingArr) * 100, 1);
            $twoStarPercent = round(countOccurrencesInArr($reviewRatingArr, 2) / count($reviewRatingArr) * 100, 1);
            $oneStarPercent = round(countOccurrencesInArr($reviewRatingArr, 1) / count($reviewRatingArr) * 100, 1);
        }
        else
        {   
            $errorMsg = "Movie not found";
            $success = false;
        }
        
        $stmt->close();
        $conn->close();
    }
}

?>


<html lang="en">
    <head>
        <title><?=$movieTitle?></title>
        <?php
            include "head.inc.php";
        ?>
        <link rel="stylesheet" href="css/movie_template.css">
        <!-- Custom JS -->
        <script defer src="js/movie_template.js"></script>
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
            <div class="card">
                <img src="data:image/jpeg;base64,<?=chunk_split(base64_encode($poster_landscape))?>" class="card-img-top" alt="<?=$movieTitle?> Movie Poster">
                <div class="row card-body">
                    <div class="col-7">
                        <div class="card-title">
                            <h3 class="display-4"><?=$movieTitle?></h3>
                        </div>
                        <p class="card-text">
                            <?=$description?>
                        </p>
                        <p class="card-text text-muted small">Released on <?=$releaseDate?></p>
                        <span class="btn-static"><?=$maturityRating?></span>
                        <span class="btn-static"><?=$length?>min</span>
                    </div>

                    <div class="col-5 card-text">
                        <h6 class="text-muted">Director:</h6>
                        <h6><?=$director?></h6>

                        <h6 class="text-muted">Producer:</h6>
                        <h6><?=$producer?></h6>

                        <h6 class="text-muted">Cast:</h6>
                        <h6><?=$actors?></h6>

                        <h6 class="mt-5 text-muted">Genre:</h6>
                        <h6><?=$genre?></h6>
                    </div>
                </div>
            </div>

            <div class="review">
                <h1>Ratings and Reviews</h1>
                <div class="card">
                    <div class="card-body row">
                        <div class="col-xs-3 col-sm-4 col-md-3 text-center">
                            <h1 class="display-3"><?=$average_rating?></h1>
                            <h6 class="text-muted"><?=$review_count?> Reviews</h6>
                        </div>
                        <div class="col-xs-9 col-sm-8 col-md-9">
                            <div class="row">
                                <!-- 5 Star Ratings -->
                                <div class="col-xs-1 col-md-2 text-right">5 <span class="star-rating-small">★</span></div>
                                <div class="col-xs-11 col-md-10">
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: <?=$fiveStarPercent?>%"
                                             aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                                            <?=$fiveStarPercent?>%
                                        </div>
                                    </div>
                                </div>

                                <!-- 4 Star Ratings -->
                                <div class="col-xs-1 col-md-2 text-right">4 <span class="star-rating-small">★</span></div>
                                <div class="col-xs-11 col-md-10">
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="60"
                                             aria-valuemin="0" aria-valuemax="100" style="width: <?=$fourStarPercent?>%">
                                            <?=$fourStarPercent?>%
                                        </div>
                                    </div>
                                </div>

                                <!-- 3 Star Ratings -->
                                <div class="col-xs-1 col-md-2 text-right">3 <span class="star-rating-small">★</span></div>
                                <div class="col-xs-11 col-md-10">
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="40"
                                             aria-valuemin="0" aria-valuemax="100" style="width: <?=$threeStarPercent?>%">
                                            <?=$threeStarPercent?>%
                                        </div>
                                    </div>
                                </div>

                                <!-- 2 Star Ratings -->
                                <div class="col-xs-1 col-md-2 text-right">2 <span class="star-rating-small">★</span></div>
                                <div class="col-xs-11 col-md-10">
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="20"
                                             aria-valuemin="0" aria-valuemax="100" style="width: <?=$twoStarPercent?>%">
                                            <?=$twoStarPercent?>%
                                        </div>
                                    </div>
                                </div>

                                <!-- 1 Star Ratings -->
                                <div class="col-xs-1 col-md-2 text-right">1 <span class="star-rating-small">★</span></div>
                                <div class="col-xs-11 col-md-10">
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="15"
                                             aria-valuemin="0" aria-valuemax="100" style="width: <?=$oneStarPercent?>%">
                                            <?=$oneStarPercent?>%
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="leave-review">
                    <?php
                        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"])
                        {
                            $userID = $_SESSION["userID"];
                    ?>
                    <form action="process_review.php" method="post">
                        <h3>Leave a review</h3>
                        <div class="form-group rating star-rating">
                            <input type="hidden" name="movieID" id="movieID"
                                   value="<?=$movieID?>">
                            <input type="hidden" name="intent" id="intent" value="posted">
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
                            <input required class="form-control col-5" type="text" placeholder="Enter title" id="review_title" name="review_title" maxlength="50">
                        </div>
                        <div class="form-group">
                            <label class="visually-hidden" for="review_writeup">Message</label>
                            <textarea required class="form-control" rows="2" placeholder="Enter your review here" id="review_writeup" name="review_writeup"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">Post review</button>
                    </form>
                    <?php
                        } else
                        {
                            echo '<h3><a href="login.php">Login</a> or <a href="register.php">sign up</a> to leave a review</h3>';
                        }
                    ?>
                </div>

                <div class="review">
                    <div>
                        <?php
                        for ($index = 0; $index < sizeof($reviewRatingArr); $index++)
                        {
                        ?>
                        <hr class="review-divider"/>
                        <div class="row review-block">
                            <div class="col-4 col-md-3">
                                <img class="avatar" src="<?=$profilePicArr[$index]?>" alt="<?=$usernameArr[$index]?> Reviewer Profile Picture">
                                <h5><?=$usernameArr[$index]?></h5>
                                <h6 class="small"><?=$reviewDateArr[$index]?></h6>
                            </div>
                            <div class="col-8 col-md-9 mt-4">
                                <?php
                                if ($userIDArr[$index] == $userID)
                                { 
                                ?>
                                <div>
                                    <button type="button" class="close" data-toggle="modal" data-target="#confirm" aria-label="Delete Review" title="Delete Review">
                                        <span aria-hidden="true">&times;</span>
                                    </button>

                                    <!-- Confirm review deletion -->
                                    <div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="DeleteReview" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="DeleteReview">Delete Review</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this review?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <a class="btn btn-danger" href="delete_review.php?reviewID=<?=$reviewIDArr[$index]?>" role="button">
                                                        Delete Review
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                }
                                ?>
                                <div class="star-rating-reviews">
                                    <?php
                                    for ($number = 0; $number < $reviewRatingArr[$index]; $number++)
                                    {
                                    ?>
                                    <span>★</span
                                    <?php
                                    }
                                    ?>
                                    >
                                </div>
                                <h5><?=$reviewTitleArr[$index]?></h5>
                                <p><?=$writeupArr[$index]?></p>
                                <?php
                                if ($userIDArr[$index] == $userID)
                                { 
                                ?>
                                <div class="review-movie">
                                    <a href="edit_review.php?reviewID=<?=$reviewIDArr[$index]?>">
                                        <i class="material-icons align-middle">create</i>
                                        Edit Review
                                    </a>
                                </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                        <hr class="review-divider"/>
                    </div>
                </div>
            </div>
            <?php
            } else
                {
                    echo "<h1 class='display-4'>Oops!</h1>";
                    echo "<h3>The following input errors were detected:</h3>";
                    echo "<p class='text-secondary'>" . $errorMsg . "</p>";
                    echo '<a class="btn btn-danger mb-3" href="index.php" role="button">Return to Home page</a>';
                }
            ?>
        </main>
         
        <?php
            unset($movieTitle, $description, $genre, $director, $producer, $actors, $length, $releaseDate, $maturityRating, $poster_landscape, $errorMsg);
            unset($review_count, $average_rating, $fiveStarPercent, $fourStarPercent, $threeStarPercent, $twoStarPercent, $oneStarPercent);
            unset($reviewRatingArr, $reviewTitleArr, $writeupArr, $reviewDateArr, $usernameArr, $profilePicArr, $userIDArr, $reviewIDArr, $number, $index);
            include "footer.inc.php";
        ?>
    </body>
</html>