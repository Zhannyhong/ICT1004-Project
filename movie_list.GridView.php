<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$movieIDArr = $movieTitleArr = $poster_portraitArr = $latestDesptArr = array();
$errorMsg = "";
$success = true;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    fetchAllLatestMovies();
} else {
    $errorMsg = "This page is not to be run directly.";
    $success = false;
}

//Helper function to fetch all movies sort by latest movies come first.
function fetchAllLatestMovies() {
    global $movieIDArr, $movieTitleArr, $poster_portraitArr, $latestDesptArr, $errorMsg, $success;

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
        $stmt = $conn->prepare("SELECT m.movieID, m.movieTitle, 
            m.poster_portrait, m.description FROM movies AS m ORDER BY releaseDate DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows < 1) {
            $errorMsg = "Movies not found";
            $success = false;
        }
        $stmt->close();
        $conn->close();

        $count = 0;
        while ($row = $result->fetch_assoc()) {
//            if ($count < 8) {
            array_push($movieIDArr, $row['movieID']);
            array_push($movieTitleArr, $row['movieTitle']);
            array_push($poster_portraitArr, $row['poster_portrait']);
            array_push($latestDesptArr, $row["description"]);
            $count = $count + 1;
//            } else {
//                break;
//            }
        }
    }
}
?>


<div class="container">
    <div class="allmovies">
        <h3>Movies</h3>
        <hr>
        <div class="movie-poster-grid">
            <?php
            if ($success) {

                for ($index = 0; $index < sizeof($movieTitleArr); $index++) {
                    ?>
                    <div class="m1">
                        <a href="movie_details.php?id=<?= $movieIDArr[$index] ?>">
                            <img class="" src="data:image/jpeg;base64,
                                 <?= chunk_split(base64_encode($poster_portraitArr[$index])) ?>" 
                                 alt="<?= $movieTitleArr[$index] ?>">
                        </a>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>
