<?php
$movieIDArr = $movieTitleArr = $poster_portraitArr = $latestDesptArr = array();
$errorMsg = "";
$success = true;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    require "connect_database.php";

    if ($success)
        fetchAllMovies();
    $conn->close();
} else {
    $errorMsg = "This page is not to be run directly.";
    $success = false;
}

//Helper function to fetch all movies sort by latest movies come first.
function fetchAllMovies() {
    global $conn, $movieIDArr, $movieTitleArr, $poster_portraitArr, $latestDesptArr, $errorMsg, $success;

    // lowercase search input
    $stmt = $conn->prepare("SELECT m.movieID, m.movieTitle, m.poster_portrait, m.description FROM movies AS m ORDER BY releaseDate DESC");
    require "handle_sql_execute_failure.php";

    if ($result->num_rows < 1) {
        $errorMsg = "Movies not found";
        $success = false;
    }

    while ($row = $result->fetch_assoc()) {
        array_push($movieIDArr, $row['movieID']);
        array_push($movieTitleArr, $row['movieTitle']);
        array_push($poster_portraitArr, $row['poster_portrait']);
        array_push($latestDesptArr, $row["description"]);
    }
}
?>

<div class="allmovies">
    <h1 class="font-weight-light style-line mx-2">All Movies</h1>
    <div class="movie-poster-grid">
        <?php
        if ($success) {

            for ($index = 0; $index < sizeof($movieTitleArr); $index++) {
                ?>
                <div class="m1">
                    <a href="movie_details.php?id=<?= $movieIDArr[$index] ?>">
                        <img class="gridimg" src="data:image/jpeg;base64,<?= base64_encode($poster_portraitArr[$index]) ?>"
                             alt="<?= $movieTitleArr[$index] ?>">
                        <div class="overlay">
                            <div class="textoverlay"><?= $movieTitleArr[$index] ?></div>
                        </div>
                    </a>
                </div>
                <?php
            }
        }
        ?>
    </div>
</div>

