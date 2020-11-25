<?php

$movieTitle = $genre = $actors = $releaseDate = $poster_portrait = $search_input = $errorMsg = "";
$success = true;

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (empty($_POST["search_input"]))
    {
        $errorMsg .= "An input is required.<br>";
        $success = false;
    }
    else
    {
        $search_input = sanitize_input($_POST["search_input"]);
        getSearchResults();
    }
}
else
{
    echo "<h2>This page is not to be run directly.</h2>";
    echo "<a href='index.php'>Return to Home Page...</a>";
    exit();
}


//Helper function to fetch movie data.
function getSearchResults()
{
    global $movieTitle, $genre, $actors, $releaseDate, $poster_landscape, $search_input;

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
        $stmt = $conn->prepare("SELECT * FROM movies WHERE movieTitle=?");
        $stmt->bind_param("s", $search_input);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1)
        {
            $row = $result->fetch_assoc();
            $movieID = $row["movieID"];
            $movieTitle = $row["movieTitle"];
            $genre = $row["genre"];
            $actors = $row["actors"];
            $releaseDate = $row["releaseDate"];
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

//Helper function that checks input for malicious or unwanted content.
function sanitize_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>


<!DOCTYPE html>

<html lang="en">
    <head>
        <?php
            include "head.inc.php";
        ?>
        <title>Search Results for Movie</title>
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <?php
            include "nav.inc.php";
        ?>
        <main class="container">
            
            <section id="review">
                <h1>Search Results</h1>

                <div class="row">
                    <div class="review-block">
                        <hr/>
                        <div class="row">
                            <div class="col-3">
                                <img class="mini-movie-poster" src="data:image/jpeg;base64,<?=chunk_split(base64_encode($poster_landscape))?>" alt="Movie Poster">

                            </div>
                            <div class="col-9 mt-4">
                                <div id="star-rating">⭐⭐⭐⭐⭐</div>
                                <h5><?=utf8_decode($movieTitle)?></h5>
                                <h6 class="small text-muted">Release date: <?=$releaseDate?></h6>
                                
                                <h6> Movie Genre: <?=utf8_decode($genre)?> </h6>
                                <p>
                                    Cast: <?=utf8_decode($actors)?>
                                </p>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                           <div class="col-3">
                                <img class="mini-movie-poster" src="images/movies/Avengers_Endgame_Portrait_cited.jpg" alt="Movie Poster">

                            </div>
                            <div class="col-9 mt-4">
                                <div id="star-rating">⭐⭐⭐⭐⭐</div>
                                <h5>Movie Title</h5>
                                <h6 class="small text-muted">Movie Release Year</h6>
                                
                                <h6> Movie Genre: Action </h6>
                                <p>
                                    Cast: Robert Downey Junior, Chris Evans, Chris Hemsworth
                                </p>
                            </div>
                        </div>
                        <hr/>
                    </div>
                </div>
            </section>
        </main>
        
        <?php
            include "footer.inc.php";
        ?>
    </body>
</html>