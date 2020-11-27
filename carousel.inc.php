<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$latestMovieIDArr = $latestMovieTitleArr = $latestPoster_portraitArr = $latestPoster_LandArr = array();
$movieIDArr = $movieTitleArr = $poster_portraitArr = array();
$search_input = $errorMsg = "";
$success = true;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    fetchLatestMovies();
    fetchTopRatedMovies();
} else {
    $errorMsg = "This page is not to be run directly.";
    $success = false;
}

//Helper function to fetch latest movies.
function fetchLatestMovies() {
    global $latestMovieIDArr, $latestMovieTitleArr, $latestPoster_portraitArr, $latestPoster_LandArr, $errorMsg, $success;

    // Create database connection.
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

    // Check connection
    if ($conn->connect_error) {
        $conn->close();
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } else {
        // lowercase search input
        $stmt = $conn->prepare("SELECT * FROM movies
                               ORDER BY releaseDate DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows < 1) {
            $errorMsg = "Movies not found";
            $success = false;
        }

        $count = 0;
        while ($row = $result->fetch_assoc()) {
            if ($count < 8) {
                array_push($latestPoster_LandArr, $row['poster_landscape']);
                array_push($latestMovieIDArr, $row['movieID']);
                array_push($latestMovieTitleArr, $row['movieTitle']);
                array_push($latestPoster_portraitArr, $row['poster_portrait']);
                $count = $count + 1;
            } else {
                break;
            }
        }
    }
}

function fetchTopRatedMovies() {
    global $movieIDArr, $movieTitleArr, $poster_portraitArr, $errorMsg, $success;

    // Create database connection.
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

    // Check connection
    if ($conn->connect_error) {
        $conn->close();
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } else {
        // lowercase search input
        $stmt = $conn->prepare("SELECT * FROM movies as m
join (SELECT y.movieID as id FROM 
(SELECT r.movieID FROM reviews as r ORDER BY r.reviewRating DESC LIMIT 0,8) as y) as x
on m.movieID in (x.id)");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows < 1) {
            $errorMsg = "Movies not found";
            $success = false;
        } elseif ($result->num_rows < 8) {
            
        }
        $stmt->close();
        $conn->close();

        $count = 0;
        while ($row = $result->fetch_assoc()) {
            if ($count < 8) {
                array_push($movieIDArr, $row['movieID']);
                array_push($movieTitleArr, $row['movieTitle']);
                array_push($poster_portraitArr, $row['poster_portrait']);
                $count = $count + 1;
            } else {
                break;
            }
        }
    }
}
?>

<div class="container">
    <!-----Slider----->
    <?php
    if ($success) {
        ?>
        <div id="slide">
            <div id="homeSlider" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#homeSlider" data-slide-to="0" class="active"></li>
                    <li data-target="#homeSlider" data-slide-to="1"></li>
                    <li data-target="#homeSlider" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <?php
                    for ($i = 0; $i < 3; $i++) {
                        if ($i === 0) {
                            ?>
                            <div class="carousel-item active">
                                <a href="movie_template.php?id=<?= $movieIDArr[$i] ?>">
                                    <img class="d-block w-100" src="data:image/jpeg;base64,<?= chunk_split(base64_encode($latestPoster_LandArr[$i])) ?>" title="<?= $movieTitleArr[$i] ?>" width="100%" height="auto">
                                </a>
                            </div>
                            <div class="carousel-item">
                                <?php
                            } else if ($i === 1) {
                                ?>
                                <a href="movie_template.php?id=<?= $movieIDArr[$i] ?>">
                                    <img class="d-block w-100" src="data:image/jpeg;base64,<?= chunk_split(base64_encode($latestPoster_LandArr[$i])) ?>" title="<?= $movieTitleArr[$i] ?>" width="100%" height="auto">
                                </a>
                            </div>
                            <div class="carousel-item">
                                <?php
                            } else {
                                ?>
                                <a href="movie_template.php?id=<?= $movieIDArr[$i] ?>">
                                    <img class="d-block w-100" src="data:image/jpeg;base64,<?= chunk_split(base64_encode($latestPoster_LandArr[$i])) ?>" title="<?= $movieTitleArr[$i] ?>" width="100%" height="auto">
                                </a>
                            </div>
                            <?php
                        }
                    }
                }
                ?>
                <a class="carousel-control-prev" href="#homeSlider" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#homeSlider" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
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
                            for ($x = 0; $x < 8; $x++) {
                                if ($x === 0) {
                                    ?>

                                    <!--First slide-->
                                    <div class="carousel-item active">

                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="card mb-2">
                                                    <a href="movie_template.php?id=<?= $movieIDArr[$x] ?>">
                                                        <img class="card-img" src="data:image/jpeg;base64,<?= chunk_split(base64_encode($poster_portraitArr[$x])) ?>" alt="<?= $movieTitleArr[$x] ?>">
                                                    </a>
                                                </div>
                                            </div>

                                            <?php
                                        } else if ($x === 1) {
                                            ?>

                                            <div class="col-md-3">
                                                <div class="card mb-2">
                                                    <a href="movie_template.php?id=<?= $movieIDArr[$x] ?>">
                                                        <img class="card-img" src="data:image/jpeg;base64,<?= chunk_split(base64_encode($poster_portraitArr[$x])) ?>" alt="<?= $movieTitleArr[$x] ?>">
                                                    </a>
                                                </div>
                                            </div>

                                            <?php
                                        } else if ($x === 2) {
                                            ?>

                                            <div class="col-md-3">
                                                <div class="card mb-2">
                                                    <a href="movie_template.php?id=<?= $movieIDArr[$x] ?>">
                                                        <img class="card-img" src="data:image/jpeg;base64,<?= chunk_split(base64_encode($poster_portraitArr[$x])) ?>" alt="<?= $movieTitleArr[$x] ?>">
                                                    </a>
                                                </div>
                                            </div>

                                            <?php
                                        } else if ($x === 3) {
                                            ?>

                                            <div class="col-md-3">
                                                <div class="card mb-2">
                                                    <a href="movie_template.php?id=<?= $movieIDArr[$x] ?>">
                                                        <img class="card-img" src="data:image/jpeg;base64,<?= chunk_split(base64_encode($poster_portraitArr[$x])) ?>" alt="<?= $movieTitleArr[$x] ?>">
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
                                        } else if ($x === 4) {
                                            ?>

                                            <div class="col-md-3 d-none d-md-block">
                                                <div class="card mb-2">
                                                    <a href="movie_template.php?id=<?= $movieIDArr[$x] ?>">
                                                        <img class="card-img-top" src="data:image/jpeg;base64,<?= chunk_split(base64_encode($poster_portraitArr[$x])) ?>" alt="<?= $movieTitleArr[$x] ?>">
                                                    </a>
                                                </div>
                                            </div>

                                            <?php
                                        } else if ($x === 5) {
                                            ?>

                                            <div class="col-md-3 d-none d-md-block">
                                                <div class="card mb-2">
                                                    <a href="movie_template.php?id=<?= $movieIDArr[$x] ?>">
                                                        <img class="card-img-top" src="data:image/jpeg;base64,<?= chunk_split(base64_encode($poster_portraitArr[$x])) ?>" alt="<?= $movieTitleArr[$x] ?>">
                                                    </a>
                                                </div>
                                            </div>

                                            <?php
                                        } else if ($x === 6) {
                                            ?>

                                            <div class="col-md-3 d-none d-md-block">
                                                <div class="card mb-2">
                                                    <a href="movie_template.php?id=<?= $movieIDArr[$x] ?>">
                                                        <img class="card-img-top" src="data:image/jpeg;base64,<?= chunk_split(base64_encode($poster_portraitArr[$x])) ?>" alt="<?= $movieTitleArr[$x] ?>">
                                                    </a>
                                                </div>
                                            </div>

                                            <?php
                                        } else {
                                            ?>

                                            <div class="col-md-3">
                                                <div class="card mb-2">
                                                    <a href="movie_template.php?id=<?= $movieIDArr[$x] ?>">
                                                        <img class="card-img" src="data:image/jpeg;base64,<?= chunk_split(base64_encode($poster_portraitArr[$x])) ?>" alt="<?= $movieTitleArr[$x] ?>">
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
                                                    <a href="movie_template.php?id=<?= $latestMovieIDArr[$index] ?>">
                                                        <img class="card-img" src="data:image/jpeg;base64,<?= chunk_split(base64_encode($latestPoster_portraitArr[$index])) ?>" alt="<?= $movieTitleArr[$index] ?>">
                                                    </a>
                                                </div>
                                            </div>

                                            <?php
                                        } else if ($index === 1) {
                                            ?>

                                            <div class="col-md-3">
                                                <div class="card mb-2">
                                                    <a href="movie_template.php?id=<?= $latestMovieIDArr[$index] ?>">
                                                        <img class="card-img" src="data:image/jpeg;base64,<?= chunk_split(base64_encode($latestPoster_portraitArr[$index])) ?>" alt="<?= $movieTitleArr[$index] ?>">
                                                    </a>
                                                </div>
                                            </div>

                                            <?php
                                        } else if ($index === 2) {
                                            ?>

                                            <div class="col-md-3">
                                                <div class="card mb-2">
                                                    <a href="movie_template.php?id=<?= $latestMovieIDArr[$index] ?>">
                                                        <img class="card-img" src="data:image/jpeg;base64,<?= chunk_split(base64_encode($latestPoster_portraitArr[$index])) ?>" alt="<?= $movieTitleArr[$index] ?>">
                                                    </a>
                                                </div>
                                            </div>

                                            <?php
                                        } else if ($index === 3) {
                                            ?>

                                            <div class="col-md-3">
                                                <div class="card mb-2">
                                                    <a href="movie_template.php?id=<?= $latestMovieIDArr[$index] ?>">
                                                        <img class="card-img" src="data:image/jpeg;base64,<?= chunk_split(base64_encode($latestPoster_portraitArr[$index])) ?>" alt="<?= $movieTitleArr[$index] ?>">
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
                                        } else if ($index === 4) {
                                            ?>

                                            <div class="col-md-3 d-none d-md-block">
                                                <div class="card mb-2">
                                                    <a href="movie_template.php?id=<?= $latestMovieIDArr[$index] ?>">
                                                        <img class="card-img-top" src="data:image/jpeg;base64,<?= chunk_split(base64_encode($latestPoster_portraitArr[$index])) ?>" alt="<?= $movieTitleArr[$index] ?>">
                                                    </a>
                                                </div>
                                            </div>

                                            <?php
                                        } else if ($index === 5) {
                                            ?>

                                            <div class="col-md-3 d-none d-md-block">
                                                <div class="card mb-2">
                                                    <a href="movie_template.php?id=<?= $latestMovieIDArr[$index] ?>">
                                                        <img class="card-img-top" src="data:image/jpeg;base64,<?= chunk_split(base64_encode($latestPoster_portraitArr[$index])) ?>" alt="<?= $movieTitleArr[$index] ?>">
                                                    </a>
                                                </div>
                                            </div>

                                            <?php
                                        } else if ($index === 6) {
                                            ?>

                                            <div class="col-md-3 d-none d-md-block">
                                                <div class="card mb-2">
                                                    <a href="movie_template.php?id=<?= $latestMovieIDArr[$index] ?>">
                                                        <img class="card-img-top" src="data:image/jpeg;base64,<?= chunk_split(base64_encode($latestPoster_portraitArr[$index])) ?>" alt="<?= $movieTitleArr[$index] ?>">
                                                    </a>
                                                </div>
                                            </div>

                                            <?php
                                        } else {
                                            ?>

                                            <div class="col-md-3">
                                                <div class="card mb-2">
                                                    <a href="movie_template.php?id=<?= $latestMovieIDArr[$index] ?>">
                                                        <img class="card-img" src="data:image/jpeg;base64,<?= chunk_split(base64_encode($latestPoster_portraitArr[$index])) ?>" alt="<?= $movieTitleArr[$index] ?>">
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
        ?>
    </div>
