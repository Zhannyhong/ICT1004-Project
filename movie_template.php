<!DOCTYPE html>

<html lang="en">
    <head>
        <?php
            include "head.inc.php";
        ?>
        <title>Individual Movie Review Template</title>
        <link rel="stylesheet" href="css/movie_template.css">
    </head>
    <body>
        <?php
            include "nav.inc.php";
        ?>
        <main class="container">
            <div class="card">
                <img src="images/chihuahua_large.jpg" class="card-img-top" alt="Movie Poster">
                <div class="row card-body">
                    <div class="col-7">
                        <div class="row col-7 card-title">
                            <h3 class="display-4">Movie Title</h3>

                        </div>
                        <p class="card-text">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            Duis eget euismod mauris. Cras vitae tincidunt massa,
                            sed tincidunt enim. Quisque rhoncus porta libero quis
                            vulputate. Fusce ac viverra ex, ac rutrum libero.
                            Mauris ac ipsum dui. Maecenas quis mi vulputate,
                            convallis massa vitae, vehicula tellus. Morbi sit amet
                            nisl quis lectus commodo laoreet. Nam sagittis quis diam
                            at aliquam. Mauris elit leo, efficitur nec erat ac,
                            feugiat ullamcorper diam. Donec molestie quam a arcu
                            mollis placerat.
                        </p>
                        <p class="card-text text-muted small">Released on 1 November 2020</p>
                        <span class="btn-static">PG13</span>
                        <span class="btn-static">138 mins</span>
                    </div>

                    <div class="col-5 card-text">
                        <h6 class="text-muted">Director:</h6>
                        <h6>Quentin Tarantino</h6>

                        <h6 class="text-muted">Producer:</h6>
                        <h6>Steven Spielberg</h6>

                        <h6 class="text-muted">Cast:</h6>
                        <h6>Matt Damon, Luke Evans, Rami Malek, Angelina Jolie</h6>

                        <h6 class="mt-5 text-muted">Genre:</h6>
                        <h6>Thriller, Crime</h6>
                    </div>
                </div>
            </div>

            <div class="review">
                <h1>Ratings and Reviews</h1>
                <div class="card">
                    <div class="card-body row">
                        <div class="col-xs-3 col-sm-4 col-md-3 text-center">
                            <h1 class="display-3">4.2</h1>
                            <h6 class="text-muted">1434 Reviews</h6>
                        </div>
                        <div class="col-xs-9 col-sm-8 col-md-9">
                            <div class="row">
                                <!-- 5 Star Ratings -->
                                <div class="col-xs-1 col-md-2 text-right">5 ⭐</div>
                                <div class="col-xs-11 col-md-10">
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 80%"
                                             aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                                            80%
                                        </div>
                                    </div>
                                </div>

                                <!-- 4 Star Ratings -->
                                <div class="col-xs-1 col-md-2 text-right">4 ⭐</div>
                                <div class="col-xs-11 col-md-10">
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="60"
                                             aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                            60%
                                        </div>
                                    </div>
                                </div>

                                <!-- 3 Star Ratings -->
                                <div class="col-xs-1 col-md-2 text-right">3 ⭐</div>
                                <div class="col-xs-11 col-md-10">
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="40"
                                             aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            40%
                                        </div>
                                    </div>
                                </div>

                                <!-- 2 Star Ratings -->
                                <div class="col-xs-1 col-md-2 text-right">2 ⭐</div>
                                <div class="col-xs-11 col-md-10">
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="20"
                                             aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                            20%
                                        </div>
                                    </div>
                                </div>

                                <!-- 1 Star Ratings -->
                                <div class="col-xs-1 col-md-2 text-right">1 ⭐</div>
                                <div class="col-xs-11 col-md-10">
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="15"
                                             aria-valuemin="0" aria-valuemax="100" style="width: 15%">
                                            15%
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="leave-review">
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="review">Leave a Review</label>
                            <input required class="form-control col-5" type="text" placeholder="Enter a title" id="review" name="review_title" maxlength="50">
                            <textarea required class="form-control" rows="2" placeholder="Enter your review here" id="review" name="review_writeup"></textarea>
                        </div>
                    </form>
                </div>


                <div class="review">
                    <div>
                        <hr class="review-divider"/>
                        <div class="row review-block">
                            <div class="col-4 col-md-3">
                                <img class="avatar" src="images/tabby_small.jpg" alt="Reviewer Profile Picture">
                                <h5>Bryan Lam</h5>
                                <h6 class="small">November 25, 2020</h6>
                            </div>
                            <div class="col-8 col-md-9 mt-4">
                                <div>⭐⭐⭐⭐⭐</div>
                                <h5>Good shit</h5>
                                <p>
                                    Cras sit amet nibh libero, in gravida nulla. Nulla vel
                                    metus scelerisque ante sollicitudin. Cras purus odio,
                                    vestibulum in vulputate at, tempus viverra turpis.
                                </p>
                            </div>
                        </div>
                        <hr class="review-divider"/>
                        <div class="row review-block">
                            <div class="col-4 col-md-3">
                                <img class="avatar" src="images/tabby_small.jpg" alt="Reviewer Profile Picture">
                                <h5>Yong Jun</h5>
                                <h6 class="small">November 23, 2020</h6>
                            </div>
                            <div class="col-8 col-md-9 mt-4">
                                <div>⭐⭐⭐⭐</div>
                                <h5>Decent but can be improved</h5>
                                <p>
                                    Cras sit amet nibh libero, in gravida nulla. Nulla vel
                                    metus scelerisque ante sollicitudin. Cras purus odio,
                                    vestibulum in vulputate at, tempus viverra turpis.
                                </p>
                            </div>
                        </div>
                        <hr class="review-divider"/>
                    </div>
                </div>
            </div>
        </main>
        
        <?php
            include "footer.inc.php";
        ?>
    </body>
</html>