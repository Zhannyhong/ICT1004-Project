<?php
/*
require 'Zebra_Session.php';
$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
$session = new Zebra_Session($conn, 'sEcUr1tY_c0dE');
*/
session_start();

$latestMovieIDArr = $latestMovieTitleArr = $latestPoster_portraitArr = array();
$search_input = $errorMsg = "";
$success = true;

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    fetchLatestMovies();
}
else
{
    $errorMsg = "This page is not to be run directly.";
    $success = false;
}

//Helper function to fetch latest movies.
function fetchLatestMovies()
{
    global $latestMovieIDArr, $latestMovieTitleArr, $latestPoster_portraitArr, $errorMsg, $success;

    // Create database connection.
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    
    // Check connection
    if ($conn->connect_error)
    {
        $conn->close();
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    }
    else
    {
        // lowercase search input
        $stmt = $conn->prepare("SELECT * FROM movies
                               ORDER BY releaseDate DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows < 1)
        {   
            $errorMsg = "Movies not found";
            $success = false;
        }
        
        $stmt->close();
        $conn->close();
        
        $count = 0;
        while ($row = $result->fetch_assoc()) {
            if ($count < 8)
            {
                array_push($latestMovieIDArr, $row['movieID']);
                array_push($latestMovieTitleArr, $row['movieTitle']);
                array_push($latestPoster_portraitArr, $row['poster_portrait']);
                $count = $count + 1;   
            } else
            {  
                break;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Popcorn Homepage</title>
        <?php
            include "head.inc.php";
        ?>
        <!-- Custom JS -->
        <script defer src="js/main.js"></script>
    </head>
    <body>    
        <?php
            include "nav.inc.php";
        ?>
            
        <!-----Main----->
        <main id="main-container" class="content">
            <div class="container">
                <!-----Slider----->
                <div id="slide">
                    <div id="homeSlider" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#homeSlider" data-slide-to="0" class="active"></li>
                            <li data-target="#homeSlider" data-slide-to="1"></li>
                            <li data-target="#homeSlider" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="images/coming-soon-slider.jpg" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="images/coming-soon-slider.jpg" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="images/movies/avengers-endgame-poster-square-crop.jpg" class="d-block w-100" alt="...">
                            </div>
                        </div>
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
                <div id="topRatedSec" class="container text-center my-3">
                    <h2 class="font-weight-light ml-auto style-line">Top Rated movies</h2>
                    <div class="row mx-auto my-auto">
                        <div id="topCarousel" class="carousel slide w-auto" data-ride="carousel">
                            <div class="carousel-inner w-100" role="listbox">
                                <div class="carousel-item active">
                                    <img class="img-fluid col-8 col-md-4 col-lg-3 col-xl-2" src="images/movies/MT.jpg">
                                </div>
                                <div class="carousel-item">
                                    <img class="img-fluid col-8 col-md-4 col-lg-3 col-xl-2" src="images/movies/13G.jpg">
                                </div>
                                <div class="carousel-item">
                                    <img class="img-fluid col-8 col-md-4 col-lg-3 col-xl-2" src="images/movies/7MA.jpg">
                                </div>
                                <div class="carousel-item">
                                    <img class="img-fluid col-8 col-md-4 col-lg-3 col-xl-2" src="images/movies/HA.jpg">
                                </div>
                                <div class="carousel-item">
                                    <img class="img-fluid col-8 col-md-4 col-lg-3 col-xl-2" src="images/movies/SI.jpg">
                                </div>
                                <div class="carousel-item">
                                    <img class="img-fluid col-8 col-md-4 col-lg-3 col-xl-2" src="images/movies/TIB.jpg">
                                </div>
                                <div class="carousel-item">
                                    <img class="img-fluid col-8 col-md-4 col-lg-3 col-xl-2" src="images/movies/TIB.jpg">
                                </div>
                                <div class="carousel-item">
                                    <img class="img-fluid col- col-md-4 col-lg-3 col-xl-2" src="images/movies/SI.jpg">
                                </div>
                            </div>
                            <a class="carousel-control-prev w-auto" href="#topCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next w-auto" href="#topCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <?php
                    if ($success)
                    {
                ?>
                <!-----Latest Movies----->
                <div id="latestSec" class="container text-center my-3">
                    <h2 class="font-weight-light mr-auto style-line">Latest movies</h2>
                    <div class="row mx-auto my-auto">
                        <div id="latestCarousel" class="carousel slide w-auto" data-ride="carousel">
                            <div class="carousel-inner w-100" role="listbox">
                                <?php
                                    for ($index = 0; $index < 8; $index++)
                                    {
                                        if ($index === 0)
                                        {
                                ?>
                                <div class="carousel-item active">
                                    <img class="img-fluid col-8 col-md-4 col-lg-3 col-xl-2" src="data:image/jpeg;base64,<?=chunk_split(base64_encode($latestPoster_portraitArr[$index]))?>" alt="<?=$movieTitleArr[$index]?>">
                                </div>
                                <?php
                                        } else
                                        {
                                ?>
                                <div class="carousel-item">
                                    <img class="img-fluid col-8 col-md-4 col-lg-3 col-xl-2" src="data:image/jpeg;base64,<?=chunk_split(base64_encode($latestPoster_portraitArr[$index]))?>" alt="<?=$movieTitleArr[$index]?>">
                                </div>
                                <?php
                                        }
                                    }
                                ?>
                            </div>
                            <a class="carousel-control-prev w-auto" href="#latestCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next w-auto" href="#latestCarousel" role="button" data-slide="next">
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
        </main>
        <?php
            include "footer.inc.php";
        ?>
    </body>
</html>