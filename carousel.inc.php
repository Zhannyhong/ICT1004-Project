<?php

$latestMovieIDArr = $latestMovieTitleArr = $latestPoster_portraitArr = array();
$movieIDArr = $movieTitleArr = $poster_portraitArr = array();
$search_input = $errorMsg = "";
$success = true;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    require "connect_database.php";

    if ($success) {
        fetchLatestMovies();
        fetchTopRatedMovies();
    }

    $conn->close();
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

//Helper function to fetch latest movies.
function fetchLatestMovies() {
    global $conn, $latestMovieIDArr, $latestMovieTitleArr, $latestPoster_portraitArr, $errorMsg, $success;

    // lowercase search input
    $stmt = $conn->prepare("SELECT m.movieID, m.movieTitle, m.poster_portrait FROM movies AS m ORDER BY releaseDate DESC LIMIT 8");
    require "handle_sql_execute_failure.php";

    if ($result->num_rows < 8) {
        $errorMsg = "Movies not found";
        $success = false;
    }

    $count = 0;
    while (($row = $result->fetch_assoc()) && ($count < 8))
    {
        array_push($latestMovieIDArr, $row['movieID']);
        array_push($latestMovieTitleArr, $row['movieTitle']);
        array_push($latestPoster_portraitArr, $row['poster_portrait']);
        $count++;
    }

}

function fetchTopRatedMovies() {
    global $conn, $movieIDArr, $movieTitleArr, $poster_portraitArr, $errorMsg, $success;

        // lowercase search input
        $stmt = $conn->prepare("SELECT m.movieID, m.movieTitle, m.poster_portrait FROM movies AS m 
            INNER JOIN (SELECT r.movieID FROM reviews as r GROUP BY r.movieID ORDER BY AVG(r.reviewRating) 
            DESC LIMIT 8) AS topMovies ON m.movieID = topMovies.movieID");
        require "handle_sql_execute_failure.php";

        if ($result->num_rows < 8) {
            $errorMsg = "Movies not found";
            $success = false;
        }

        $count = 0;
        while (($row = $result->fetch_assoc()) && ($count < 8))
        {
            array_push($movieIDArr, $row['movieID']);
            array_push($movieTitleArr, $row['movieTitle']);
            array_push($poster_portraitArr, $row['poster_portrait']);
            $count++;
        }
}
?>

<!--<div class="container" id="carouselSec">-->
    <!-----Slider----->
    <div id="slide">

        <!-----Top Rated Movies----->
        <?php
        if ($success) {
            ?>
            <div id="topRatedSec" class="container text-center my-3">
                <h2 class="font-weight-light ml-auto style-line">Top Rated movies</h2>
                <div class="row mx-auto my-auto">
                    <div id="topRated" class="carousel slide carousel-multi-item" data-ride="carousel">

                        <!--Slides-->
                        <div class="carousel-inner" role="listbox">

                            <?php
                            for ($index = 0; $index < 8; $index++) {
                                if ($index === 0) {
                                    ?>

                                    <!--First slide-->
                                    <div class="carousel-item active">

                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="card mb-2">
                                                    <a href="movie_details.php?id=<?= $movieIDArr[$index] ?>">
                                                        <img class="img-card" src="data:image/jpeg;base64,<?= chunk_split(base64_encode($poster_portraitArr[$index])) ?>" alt="<?= $movieTitleArr[$index] ?>">
                                                    </a>
                                                </div>
                                            </div>

                                            <?php
                                        } else if ($index === 1 || $index === 2) {
                                            ?>

                                            <div class="col-md-3">
                                                <div class="card mb-2">
                                                    <a href="movie_details.php?id=<?= $movieIDArr[$index] ?>">
                                                        <img class="img-card" src="data:image/jpeg;base64,<?= chunk_split(base64_encode($poster_portraitArr[$index])) ?>" alt="<?= $movieTitleArr[$index] ?>">
                                                    </a>
                                                </div>
                                            </div>

                                            <?php
                                        } else if ($index === 3) {
                                            ?>

                                            <div class="col-md-3">
                                                <div class="card mb-2">
                                                    <a href="movie_details.php?id=<?= $movieIDArr[$index] ?>">
                                                        <img class="img-card" src="data:image/jpeg;base64,<?= chunk_split(base64_encode($poster_portraitArr[$index])) ?>" alt="<?= $movieTitleArr[$index] ?>">
                                                    </a>
                                                </div>
                                            </div>


                                        </div>

                                    </div>
                                    <!--/.First slide-->

                                    <!--Second slide-->
                                    <div class="carousel-item">

                                        <div class="row">

                                            <?php
                                        } else if ($index === 4 || $index === 5 || $index === 6) {
                                            ?>

                                            <div class="col-md-3 d-none d-md-block">
                                                <div class="card mb-2">
                                                    <a href="movie_details.php?id=<?= $movieIDArr[$index] ?>">
                                                        <img class="img-card" src="data:image/jpeg;base64,<?= chunk_split(base64_encode($poster_portraitArr[$index])) ?>" alt="<?= $movieTitleArr[$index] ?>">
                                                    </a>
                                                </div>
                                            </div>

                                            <?php
                                        } else {
                                            ?>

                                            <div class="col-md-3">
                                                <div class="card mb-2">
                                                    <a href="movie_details.php?id=<?= $movieIDArr[$index] ?>">
                                                        <img class="img-card" src="data:image/jpeg;base64,<?= chunk_split(base64_encode($poster_portraitArr[$index])) ?>" alt="<?= $movieTitleArr[$index] ?>">
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!--/.Second slide-->


                                    <?php
                                }
                            }
                        }
                        ?>

                    </div>
                    <!--/.Slides-->
                    <a class="carousel-control-prev w-auto" href="#topRated" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next w-auto" href="#topRated" role="button" data-slide="next">
                        <span class="carousel-control-next-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>

        <!-----Latest Movies----->       
        <?php
        if ($success) {
            ?>
            <div id="latestSec" class="container text-center my-3">
                <h2 class="font-weight-light ml-auto style-line">Latest movies</h2>
                <div class="row mx-auto my-auto">
                    <div id="latestMovie" class="carousel slide carousel-multi-item" data-ride="carousel">

                        <!--Slides-->
                        <div class="carousel-inner" role="listbox">

                            <?php
                            for ($index = 0; $index < 8; $index++) {
                                if ($index === 0) {
                                    ?>

                                    <!--First slide-->
                                    <div class="carousel-item active">

                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="card mb-2">
                                                    <a href="movie_details.php?id=<?= $latestMovieIDArr[$index] ?>">
                                                        <img class="img-card" src="data:image/jpeg;base64,<?= chunk_split(base64_encode($latestPoster_portraitArr[$index])) ?>" alt="<?= $movieTitleArr[$index] ?>">
                                                    </a>
                                                </div>
                                            </div>

                                            <?php
                                        } else if ($index === 1 || $index === 2) {
                                            ?>

                                            <div class="col-md-3">
                                                <div class="card mb-2">
                                                    <a href="movie_details.php?id=<?= $latestMovieIDArr[$index] ?>">
                                                        <img class="img-card" src="data:image/jpeg;base64,<?= chunk_split(base64_encode($latestPoster_portraitArr[$index])) ?>" alt="<?= $movieTitleArr[$index] ?>">
                                                    </a>
                                                </div>
                                            </div>

                                            <?php
                                        } else if ($index === 3) {
                                            ?>

                                            <div class="col-md-3">
                                                <div class="card mb-2">
                                                    <a href="movie_details.php?id=<?= $latestMovieIDArr[$index] ?>">
                                                        <img class="img-card" src="data:image/jpeg;base64,<?= chunk_split(base64_encode($latestPoster_portraitArr[$index])) ?>" alt="<?= $movieTitleArr[$index] ?>">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/.First slide-->

                                    <!--Second slide-->
                                    <div class="carousel-item">

                                        <div class="row">

                                            <?php
                                        } else if ($index === 4 || $index === 5 || $index === 6) {
                                            ?>

                                            <div class="col-md-3 d-none d-md-block">
                                                <div class="card mb-2">
                                                    <a href="movie_details.php?id=<?= $latestMovieIDArr[$index] ?>">
                                                        <img class="img-card-top" src="data:image/jpeg;base64,<?= chunk_split(base64_encode($latestPoster_portraitArr[$index])) ?>" alt="<?= $movieTitleArr[$index] ?>">
                                                    </a>
                                                </div>
                                            </div>

                                            <?php
                                        } else {
                                            ?>

                                            <div class="col-md-3">
                                                <div class="card mb-2">
                                                    <a href="movie_details.php?id=<?= $latestMovieIDArr[$index] ?>">
                                                        <img class="img-card" src="data:image/jpeg;base64,<?= chunk_split(base64_encode($latestPoster_portraitArr[$index])) ?>" alt="<?= $movieTitleArr[$index] ?>">
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!--/.Second slide-->


                                    <?php
                                }
                            }
                            ?>

                        </div>
                        <!--/.Slides-->
                        <a class="carousel-control-prev w-auto" href="#latestMovie" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next w-auto" href="#latestMovie" role="button" data-slide="next">
                            <span class="carousel-control-next-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
            <?php
        }
        unset($errorMsg, $success, $latestMovieIDArr, $latestMovieTitleArr, $latestPoster_portraitArr, $movieIDArr, $movieTitleArr, $poster_portraitArr);
        ?>
    </div>
<!--</div>-->

