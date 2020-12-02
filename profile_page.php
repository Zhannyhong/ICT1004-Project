<?php
/*
require 'Zebra_Session.php';
$session = new Zebra_Session($conn, 'sEcUr1tY_c0dE');
*/
session_start();
?>

<html lang="en">
    <head>
        <title>Profile Page</title>
        <?php
            include "head.inc.php";
        ?>
        <link rel="stylesheet" href="css/movie_details.css">
    </head>
    <body class="d-flex flex-column min-vh-100">
        <?php
            include "nav.inc.php";

            // Checks that the user is logged in
            if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"])
            {
                // Initialise input variables
                $email = $username = $profile_pic = $errorMsg = "";
                $userID = $_SESSION["userID"];
                $success = true;

                require "connect_database.php";

                // Retrieves user info from database
                $stmt = $conn->prepare("SELECT * FROM users WHERE userID=?");
                $stmt->bind_param("s", $userID);
                require "handle_sql_execute_failure.php";

                $user_details = $result->fetch_assoc();
                $username = $user_details["username"];
                $email = $user_details["email"];
                $profile_pic = $user_details["profilePic"];

                // Retrieves user's reviews from database
                $stmt = $conn->prepare("SELECT U.profilePic, U.username, R.reviewID, R.reviewDate, R.reviewRating, R.reviewTitle, R.writeUp, M.movieID, M.movieTitle
                                        FROM users U, reviews R, movies M 
                                        WHERE R.userID=? AND R.userID=U.userID AND R.movieID=M.movieID
                                        ORDER BY R.reviewDate DESC");
                $stmt->bind_param("s", $userID);
                require "handle_sql_execute_failure.php";
                $conn->close();
                $review_count = $result->num_rows;
                unset($userID);
            }
            else
            {
                require "illegal_access.php";
                echo '<a class="btn btn-danger my-4" href="login.php" role="button">Login Here</a>';
                echo "</div>";
                echo "</body>";
                include "footer.inc.php";
                exit();
            }
        ?>
        <main class="container flex-grow-1">
            <div class="profile rounded shadow-sm card-background">
                <img class="avatar" src="<?=$profile_pic?>" alt="Profile Picture">
                <h6 class="small text-muted">Username:</h6>
                <h5 class="mb-4"><?=$username?></h5>

                <h6 class="small text-muted">Email:</h6>
                <h5 class="mb-3"><?=$email?></h5>

                <div class="row" id="profile-settings">
                    <ul class="list-unstyled">
                        <li>
                            <a href="edit_profile.php" title="Edit Profile" id="edit-profile">
                                <i class="material-icons align-middle">create</i>
                                Edit Profile
                            </a>
                        </li>

                        <li>
                            <a href="logout.php" title="Log Out" id="log-out">
                                <i class="material-icons align-middle">power_settings_new</i>
                                Log Out
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Display all reviews user made -->
            <div class="review">
                <h1 class="display-4">Your Reviews</h1>
                <p class="font-italic">Review Count: <?=$review_count?></p>
                <div>
                    <hr class="review-divider"/>
                    <?php
                    $_SESSION['current_review_location'] = 'profile_page.php';
                    while ($row = $result->fetch_assoc()) {
                    ?>

                    <div class="row review-block">
                        <div class="col-4 col-md-3">
                            <img class="avatar" src="<?=$row['profilePic']?>" alt="Reviewer Profile Picture">
                            <h5><?=$row['username']?></h5>
                            <h6 class="small"><?=$row['reviewDate']?></h6>
                        </div>
                        <div class="col-8 col-md-9">
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
                                                <a class="btn btn-danger" href="delete_review.php?reviewID=<?=$row['reviewID']?>&movieID=<?=$row['movieID']?>" role="button">
                                                    Delete Review
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <div class="star-rating-reviews">
                                    <?php
                                    for ($number = 0; $number < $row["reviewRating"]; $number++)
                                    {
                                    ?>
                                    <span>★</span
                                    <?php
                                    }
                                    ?>
                                    >
                                </div>
                                <h5><?=$row['reviewTitle']?></h5>
                                <p><?=$row['writeUp']?></p>
                                <div class="review-movie">
                                    <p>Review for
                                        <a href="movie_details.php?id=<?=$row['movieID']?>">
                                            <?=$row['movieTitle']?>
                                        </a>
                                    </p>
                                    <a href="edit_review.php?reviewID=<?=$row['reviewID']?>">
                                        <i class="material-icons align-middle">create</i>
                                        Edit Review
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="review-divider"/>

                    <?php
                    }
                    ?>
                </div>
            </div>
        </main>
        <?php
            include "footer.inc.php";
            unset($profile_pic, $email, $username, $result, $success, $review_count);
        ?>
    </body>
</html>

