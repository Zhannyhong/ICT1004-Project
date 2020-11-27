<?php

$movieTitle = $description = $genre = $director = $producer = $actors = $length = $releaseDate = $maturityRating = $poster_landscape = $errorMsg = "";
$success = true;

// FILTER_SANITIZE_NUMBER_INT to prevent code injection
if ($_SERVER["REQUEST_METHOD"] == "GET" && filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT))
{
    $movieID = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
    fetchMovieData();
}


//Helper function to fetch movie data.
function fetchMovieData()
{
    global $movieID, $movieTitle, $description, $genre, $director, $producer, $actors, $length, $releaseDate, $maturityRating, $poster_landscape, $errorMsg, $success;

    require_once "connect_database.php";

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

<!DOCTYPE html>

<html lang="en">
    <head>
        <?php
            include "head.inc.php";
        ?>
        <title><?=$movieTitle?></title>
        <link rel="stylesheet" href="css/movie_template.css">
        <!-- Custom JS -->
        <script defer src="js/movie_template.js"></script>
    </head>
    <body>
        <?php
            include "nav.inc.php";
        ?>
        <main class="container">
            <div class="card">
                <img src="data:image/jpeg;base64,<?=chunk_split(base64_encode($poster_landscape))?>" class="card-img-top" alt="Movie Poster">
                <div class="row card-body">
                    <div class="col-7">
                        <div class="row col-7 card-title">
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
                            <h1 class="display-3">4.2</h1>
                            <h6 class="text-muted">1434 Reviews</h6>
                        </div>
                        <div class="col-xs-9 col-sm-8 col-md-9">
                            <div class="row">
                                <!-- 5 Star Ratings -->
                                <div class="col-xs-1 col-md-2 text-right">5 <span class="star-rating-small">★</span></div>
                                <div class="col-xs-11 col-md-10">
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 80%"
                                             aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                                            80%
                                        </div>
                                    </div>
                                </div>

                                <!-- 4 Star Ratings -->
                                <div class="col-xs-1 col-md-2 text-right">4 <span class="star-rating-small">★</span></div>
                                <div class="col-xs-11 col-md-10">
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="60"
                                             aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                            60%
                                        </div>
                                    </div>
                                </div>

                                <!-- 3 Star Ratings -->
                                <div class="col-xs-1 col-md-2 text-right">3 <span class="star-rating-small">★</span></div>
                                <div class="col-xs-11 col-md-10">
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="40"
                                             aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            40%
                                        </div>
                                    </div>
                                </div>

                                <!-- 2 Star Ratings -->
                                <div class="col-xs-1 col-md-2 text-right">2 <span class="star-rating-small">★</span></div>
                                <div class="col-xs-11 col-md-10">
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="20"
                                             aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                            20%
                                        </div>
                                    </div>
                                </div>

                                <!-- 1 Star Ratings -->
                                <div class="col-xs-1 col-md-2 text-right">1 <span class="star-rating-small">★</span></div>
                                <div class="col-xs-11 col-md-10">
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="15"
                                             aria-valuemin="0" aria-valuemax="100" style="width: 15%">
                                            15%
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="leave-review">
                    <form action="process_review.php" method="post">
                        <h3>Leave a review</h3>
                        <div class="form-group rating star-rating">
                            <!-- Remove whitespaces between stars -->
                            <input type="hidden" name="rating" id="rating">
                            <span data-score="1">★</span>
                            <span data-score="2">★</span>
                            <span data-score="3">★</span>
                            <span data-score="4">★</span>
                            <span data-score="5">★</span>
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
                </div>

                <div class="review">
                    <div>
                        <hr class="review-divider"/>
                        <div class="row review-block">
                            <div class="col-4 col-md-3">
                                <img class="avatar" src="images/tabby_small.jpg" alt="Reviewer Profile Picture">
                                <h5>Bryan Lam</h5>
                                <h6 class="small">November 25, 2020</h6>
                            </div>
                            <div class="col-8 col-md-9 mt-4">
                                <div class="star-rating">★★★★★</div>
                                <h5>Good shit</h5>
                                <p>
                                    Cras sit amet nibh libero, in gravida nulla. Nulla vel
                                    metus scelerisque ante sollicitudin. Cras purus odio,
                                    vestibulum in vulputate at, tempus viverra turpis.
                                </p>
                            </div>
                        </div>
                        <hr class="review-divider"/>
                        <div class="row review-block">
                            <div class="col-4 col-md-3">
                                <img class="avatar" src="images/tabby_small.jpg" alt="Reviewer Profile Picture">
                                <h5>Yong Jun</h5>
                                <h6 class="small">November 23, 2020</h6>
                            </div>
                            <div class="col-8 col-md-9 mt-4">
                                <div class="star-rating">★★★★</div>
                                <h5>Decent but can be improved</h5>
                                <p>
                                    Cras sit amet nibh libero, in gravida nulla. Nulla vel
                                    metus scelerisque ante sollicitudin. Cras purus odio,
                                    vestibulum in vulputate at, tempus viverra turpis.
                                </p>
                            </div>
                        </div>
                        <hr class="review-divider"/>
                    </div>
                </div>
            </div>
        </main>
        
        <?php
            include "footer.inc.php";
        ?>
    </body>
</html>