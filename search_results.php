<?php

$movieIDArr = $movieTitleArr = $genreArr = $actorsArr = $releaseDateArr = $poster_portraitArr = $poster_landscapeArr = array();
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
    require "illegal_access.php";
    echo '<a class="btn btn-danger my-4" href="index.php" role="button">Return Home</a>';
    echo "</div>";
    echo "</body>";
    include "footer.inc.php";
    exit();
}


//Helper function to fetch movie data.
function getSearchResults()
{
    global $movieIDArr, $movieTitleArr, $genreArr, $actorsArr, $releaseDateArr, $poster_portraitArr, $poster_landscapeArr, $search_input, $errorMsg, $success;

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
            array_push($poster_landscapeArr, $row['poster_landscape']);
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
                <?php
                   if (sizeof($movieTitleArr) > 0)
                   {
                       echo '<h1 class="mt-4">' . sizeof($movieTitleArr) . '  Search Results for "' . $search_input .'"</h1>';
                       echo '<hr/>';
                   }

                   if ($success)
                   {
                       for ($index = 0; $index < sizeof($movieTitleArr); $index++)
                       {
                ?>
                <div class="row">
                    <div class="review-block">
                        <div class="row mx-2">
                            <!-- Shows portrait posters on larger screens -->
                            <div class="d-none d-md-block col-md-3 my-auto">
                                <img class="mini-movie-poster" src="data:image/jpeg;base64,<?=chunk_split(base64_encode($poster_portraitArr[$index]))?>" alt="Movie Poster for <?=$movieTitleArr[$index]?>">
                            </div>
                            <!-- Shows landscape posters on smaller screens -->
                            <div class="d-xs-block d-md-none my-auto container">
                                <img class="mini-movie-poster" src="data:image/jpeg;base64,<?=chunk_split(base64_encode($poster_landscapeArr[$index]))?>" alt="Movie Poster for <?=$movieTitleArr[$index]?>">
                            </div>

                            <div class="col-md-9 mt-4">
                                <h1 class="display-4"><?=$movieTitleArr[$index]?></h1>
                                <h6 class="small text-muted mb-4">Release date: <?=$releaseDateArr[$index]?></h6>

                                <h5>Genre:</h5>
                                <h6 class="text-muted"><?=$genreArr[$index]?></h6>

                                <h5>Cast:</h5>
                                <h6 class="text-muted"><?=$actorsArr[$index]?></h6>

                                <a class="btn btn-success mb-3" href="movie_details.php?id=<?=$movieIDArr[$index]?>" role="button">Go to Movie</a>
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
                        require "error_msg.php";
                        echo '<a class="btn btn-danger my-4" href="index.php" role="button">Return to Home page</a>';
                        echo "</div>";
                   }
                ?>
            </section>
        </main>
        
        <?php
            unset($errorMsg, $success, $actorsArr, $genreArr, $index, $movieIDArr, $movieTitleArr, $poster_portraitArr, $poster_landscapeArr, $releaseDateArr, $search_input);
            include "footer.inc.php";
        ?>
    </body>
</html>