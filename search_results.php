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

        if ($result->num_rows < 1)
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
                
                <?php
                if ($success) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                
                
                <div class="row">
                    <div class="review-block">
                        <hr/>
                        <div class="row">
                            <div class="col-3">
                                <img class="mini-movie-poster" src="<?=$row['poster_landscape']?>" alt="Movie Poster">

                            </div>
                            <div class="col-9 mt-4">
                                <div id="star-rating">⭐⭐⭐⭐⭐</div>
                                <h5><?=$row['movieTitle']?></h5>
                                <h6 class="small text-muted">Release date: <?=$row['releaseDate']?></h6>
                                
                                <h6> Movie Genre: <?=$row['genre']?> </h6>
                                <p>
                                    Cast: <?=$row['actors']?>
                                </p>
                            </div>
                        </div>
                        <hr/>
                    </div>
                </div>
                
                <?php
                    }
                }
                else 
                {
                    echo "<h1 class='display-4'>Oops!</h1>";
                    echo "<h3>The following input errors were detected:</h3>";
                    echo "<p class='text-secondary'>" . $errorMsg . "</p>";
                    echo '<a class="btn btn-danger mb-3" href="index.php" role="button">Return to Home page</a>';
                }
                ?>
            </section>
        </main>
        
        <?php
            include "footer.inc.php";
        ?>
    </body>
</html>