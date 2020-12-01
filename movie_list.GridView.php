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
    fetchLatestMovies();
    fetchTopRatedMovies();
} else {
    $errorMsg = "This page is not to be run directly.";
    $success = false;
}

//Helper function to fetch all movies sort by latest movies come first.
function fetchAllLatestMovies() {
    global $latestMovieIDArr, $latestMovieTitleArr, $latestPoster_portraitArr, $latestDesptArr, $errorMsg, $success;

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
            m.poster_portrait m.description FROM movies AS m ORDER BY releaseDate DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows < 8) {
            $errorMsg = "Movies not found";
            $success = false;
        }
        $stmt->close();
        $conn->close();

        $count = 0;
        while ($row = $result->fetch_assoc()) {
            if ($count < 8) {
                array_push($latestMovieIDArr, $row['movieID']);
                array_push($latestMovieTitleArr, $row['movieTitle']);
                array_push($latestPoster_portraitArr, $row['poster_portrait']);
                array_push($latestDesptArr, $row["description"]);
                $count = $count + 1;
            } else {
                break;
            }
        }
    }
}
?>

<div id="btnContainer">
    <button class="btn" onclick="listView()"><i class="fa fa-bars"></i> List</button> 
    <button class="btn active" onclick="gridView()"><i class="fa fa-th-large"></i> Grid</button>
</div>
<br>

<div class="row">
    <?php
    if ($success) {
        for ($index = 0; $index < 8; $index++) {
            if ($index === 0) {
                ?>
                <div class="m-column" style="background-color:#aaa;">
                    <div class="card-horizontal">
                        <div class="img-square-wrapper">
                            <img class="" src="http://via.placeholder.com/300x180" alt="Card image cap">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">Card title</h4>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                    </div>
                    <img class="card-img-top" src="data:image/jpeg;base64,<?= chunk_split(base64_encode($poster_portraitArr[$index])) ?>"
                         alt="<?= $movieTitleArr[$index] ?>">
                    <div class="card-body">
                        <h2 class="card-title"><?= $movieTitleArr[$index] ?></h2>
                        <p class="card-text"><?= $latestDesptArr[$index] ?></p>
                    </div>
                </div>
                <div class="m-column" style="background-color:#bbb;">
                    <h2>Column 2</h2>
                    <p>Some text..</p>
                </div>
            </div>

            <div class="row">
                <div class="m-column" style="background-color:#ccc;">
                    <h2>Column 3</h2>
                    <p>Some text..</p>
                </div>
                <div class="m-column" style="background-color:#ddd;">
                    <h2>Column 4</h2>
                    <p>Some text..</p>
                </div>
                <?php
            }
        }
    }
    ?>
</div>