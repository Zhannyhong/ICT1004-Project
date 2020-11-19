<!DOCTYPE html>

<html lang="en">
    <head>
        <title>World of Pets</title>
        <?php
            include "head.inc.php";
        ?>
    </head>
    <body>
        <?php
            include "nav.inc.php";
        ?>
        <main class="container">
                <div class="profile rounded shadow-sm">
                    <img class="avatar" src="images/tabby_large.jpg" alt="Profile Picture">
                    <h6 class="small text-muted">Username:</h6>
                    <h5 class="mb-4">Some_Tabby123</h5>

                    <h6 class="small text-muted">Email:</h6>
                    <h5>tabby123@gmail.com</h5>

                    <a class="btn btn-primary" href="edit_profile.php" role="button" title="Edit Profile" id="edit-profile">
                        <i class="material-icons">create</i>
                    </a>
                </div>

                <div class="review">
                    <h1 class="display-4">Your Reviews</h1>
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
                                <div class="review-movie">
                                    <h6>Review for <a href="#" title="See more info about the movie you reviewed">Avenger's Endgame</a></h6>
                                </div>
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
                                <div class="review-movie">
                                    <h6>Review for <a href="#" title="See more info about the movie you reviewed">The Ring</a></h6>
                                </div>
                            </div>
                        </div>
                        <hr class="review-divider"/>
                    </div>
                </div>
        </main>
        <?php
            include "footer.inc.php";
        ?>
    </body>
</html>

