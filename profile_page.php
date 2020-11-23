<?php
// Create database connection
$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

// Check connection
if ($conn->connect_error)
{
    echo "<h2>Connection failed: $conn->connect_error</h2>";
    exit();
}

/*
require 'Zebra_Session.php';
$session = new Zebra_Session($conn, 'sEcUr1tY_c0dE');
*/
session_start();
print_r($_SESSION);


$userID = $_SESSION["userID"];

// Retrieves user info from database
$stmt = $conn->prepare("SELECT * FROM users WHERE userID=?");
$stmt->bind_param("s", $userID);

if (!$stmt->execute())
{
    echo "<h2>Execute failed: (' . $stmt->errno . ') ' . $stmt->error</h2>";
    exit();
}

$user_details = $stmt->get_result()->fetch_array(MYSQLI_ASSOC);
$username = $user_details["username"];
$email = $user_details["email"];
$profile_pic = $user_details["profilePic"];


// Retrieves user's reviews from database
$stmt = $conn->prepare("SELECT U.profilePic, U.username, R.reviewID, R.reviewDate, R.reviewRating, R.reviewTitle, R.writeUp, M.movieTitle
                        FROM users U, reviews R, movies M 
                        WHERE R.userID=? AND R.userID=U.userID AND R.movieID=M.movieID");
$stmt->bind_param("s", $userID);

if (!$stmt->execute())
{
    echo "<h2>Execute failed: (' . $stmt->errno . ') ' . $stmt->error</h2>";
    exit();
}

$result = $stmt->get_result();
$review_count = $result->num_rows;
$stmt->close();

?>

<html lang="en">
    <head>
        <title>World of Pets</title>
        <?php
            include "head.inc.php";
        ?>
    </head>
    <body>
        <?php
            include "nav.inc.php";
        ?>
        <main class="container">
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

            <div class="review">
                <h1 class="display-4">Your Reviews</h1>
                <p class="font-italic">Review Count: <?=$review_count?></p>
                <div>
                    <hr class="review-divider"/>
                    <?php
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
                                <div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Delete Review</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this review?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <form action="delete_review.php/?reviewID=<?=$row['reviewID']?>" method="post">
                                                    <button type="submit" class="btn btn-danger">Delete Review</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="star-rating">
                                    <?php echo str_repeat("★", $row['reviewRating']) ?>
                                </div>
                                <h5><?=$row['reviewTitle']?></h5>
                                <p><?=$row['writeUp']?></p>
                                <div class="review-movie">
                                    <h6>Review for <a href="#" title="See more info about the movie you reviewed"><?=$row['movieTitle'];?></a></h6>
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
        ?>
    </body>
</html>

