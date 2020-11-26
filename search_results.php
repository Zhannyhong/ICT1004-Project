<?php

$movieTitleArr = $genreArr = $actorsArr = $releaseDateArr = $poster_portraitArr = array();
$search_input = $errorMsg = "";
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
    global $movieTitleArr, $genreArr, $actorsArr, $releaseDateArr, $poster_portraitArr, $search_input;

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
        $search_input = strtolower($search_input);
        
        $stmt = $conn->prepare("SELECT * FROM movies
                                WHERE (LOWER(movieTitle) LIKE '%" . $search_input . "%')");

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows < 1)
        {   
            $errorMsg = "Movie not found";
            $success = false;
        } else
        {
            $success = true;
        }
        
        $stmt->close();
        $conn->close();
        
        while ($row = $result->fetch_assoc()) {
            array_push($movieTitleArr, $row['movieTitle']);
            array_push($genreArr, $row['genre']);
            array_push($actorsArr, $row['actors']);
            array_push($releaseDateArr, $row['$releaseDate']);
            array_push($poster_portraitArr, $row['$poster_portrait']);
        }
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
                
                <?php
                for ($index = 0; $index < sizeof($movieTitleArr); $index++) {
                ?>
                <div class="row">
                    <div class="review-block">
                        <hr/>
                        <div class="row">
                            <div class="col-3">
                                <img class="mini-movie-poster" src="data:image/jpeg;base64,<?=chunk_split(base64_encode($poster_portraitArr[$index]))?>" alt="Movie Poster">

                            </div>
                            <div class="col-9 mt-4">
                                <div id="star-rating">⭐⭐⭐⭐⭐</div>
                                <h5><?=$movieTitleArr[$index]?></h5>
                                <h6 class="small text-muted">Release date: <?=$releaseDateArr[$index]?></h6>
                                
                                <h6> Movie Genre: <?=$genreArr[$index]?> </h6>
                                <p>
                                    Cast: <?=$actorsArr[$index]?>
                                </p>
                            </div>
                        </div>
                        <hr/>
                    </div>
                </div>
                <?php
                }
                ?>
            </section>
        </main>
        
        <?php
            include "footer.inc.php";
        ?>
    </body>
</html>