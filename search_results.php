<!DOCTYPE html>

<html lang="en">
    <head>
        <?php
            include "head.inc.php";
        ?>
        <title>Search Results for Movie</title>
        <link rel="stylesheet" href="css/moain.css">
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