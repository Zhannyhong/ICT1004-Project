<?php

$movieIDArr = $movieTitleArr = $genreArr = $actorsArr = $releaseDateArr = $poster_portraitArr = array();
$search_input = $errorMsg = "";
$success = true;

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (empty($_POST["search_input"]))
    {
        $errorMsg = "An input is required.<br>";
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
    global $movieIDArr, $movieTitleArr, $genreArr, $actorsArr, $releaseDateArr, $poster_portraitArr, $search_input, $errorMsg, $success;

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
        $param = "%" . $search_input . "%";
        $stmt = $conn->prepare("SELECT * FROM movies
                                WHERE (LOWER(movieTitle) LIKE ?)");
        $stmt->bind_param("s", $param);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows < 1)
        {   
            $errorMsg = "Movie not found";
            $success = false;
        }
        
        $stmt->close();
        $conn->close();
        
        while ($row = $result->fetch_assoc()) {
            array_push($movieIDArr, $row['movieID']);
            array_push($movieTitleArr, $row['movieTitle']);
            array_push($genreArr, $row['genre']);
            array_push($actorsArr, $row['actors']);
            array_push($releaseDateArr, $row['releaseDate']);
            array_push($poster_portraitArr, $row['poster_portrait']);
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
        <title>Search Results for Movie</title>
        <?php
            include "head.inc.php";
        ?>
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body class="d-flex flex-column min-vh-100">
        <?php
            include "nav.inc.php";
        ?>
        <main class="container flex-grow-1">
            
            <section id="review">
                <h1 class="display-4 mt-4"><?=sizeof($movieTitleArr)?> Search Results for "<?=$search_input?>"</h1>
                <hr/>
                <?php
                    if ($success)
                    {
                        for ($index = 0; $index < sizeof($movieTitleArr); $index++)
                        {
                ?>
                <div class="row">
                    <div class="review-block">
                        <div class="row">
                            <div class="col-3 my-auto">
                                <img class="mini-movie-poster" src="data:image/jpeg;base64,<?=chunk_split(base64_encode($poster_portraitArr[$index]))?>" alt="Movie Poster for <?=$movieTitleArr[$index]?>">

                            </div>
                            <div class="col-9 mt-4">
                                <h1 class="display-4"><?=$movieTitleArr[$index]?></h1>
                                <h6 class="small text-muted mb-4">Release date: <?=$releaseDateArr[$index]?></h6>

                                <h5>Genre:</h5>
                                <h6 class="text-muted"><?=$genreArr[$index]?></h6>

                                <h5>Cast:</h5>
                                <h6 class="text-muted"><?=$actorsArr[$index]?></h6>

                                <a class="btn btn-success mb-3" href="movie_template.php?id=<?=$movieIDArr[$index]?>" role="button">Go to Movie</a>
                            </div>
                        </div>
                        <hr/>
                    </div>
                </div>
                <?php
                        }
                    } else 
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
            unset($errorMsg, $success, $actorsArr, $genreArr, $index, $movieIDArr, $movieTitleArr, $poster_portraitArr, $releaseDateArr, $search_input);
            include "footer.inc.php";
        ?>
    </body>
</html>