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
                <div class="profile rounded shadow-sm card-background">
                    <img class="avatar" src="images/tabby_large.jpg" alt="Profile Picture">
                    <h6 class="small text-muted">Username:</h6>
                    <h5 class="mb-4">Some_Tabby123</h5>

                    <h6 class="small text-muted">Email:</h6>
                    <h5 class="mb-3">tabby123@gmail.com</h5>

                    <div class="row" id="profile-settings">
                        <ul class="list-unstyled">
                            <li>
                                <a href="edit_profile.php" title="Edit Profile" id="edit-profile">
                                    <i class="material-icons align-middle">create</i>
                                    Edit Profile
                                </a>
                            </li>

                            <li>
                                <a href="login.php" title="Log Out" id="log-out">
                                    <i class="material-icons align-middle">power_settings_new</i>
                                    Log Out
                                </a>
                            </li>
                        </ul>

                    </div>
                </div>

                <div class="review">
                    <h1 class="display-4">Your Reviews</h1>
                    <p class="font-italic">Review Count: 2</p>
                    <div>
                        <hr class="review-divider"/>
                        <div class="row review-block">
                            <div class="col-4 col-md-3">
                                <img class="avatar" src="images/tabby_small.jpg" alt="Reviewer Profile Picture">
                                <h5>Bryan Lam</h5>
                                <h6 class="small">November 25, 2020</h6>
                            </div>
                            <div class="col-8 col-md-9">
                                <div>
                                    <button type="button" class="close" aria-label="Delete Review" title="Delete Review">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="mt-4">
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
                        </div>

                        <hr class="review-divider"/>
                        <div class="row review-block">
                            <div class="col-4 col-md-3">
                                <img class="avatar" src="images/tabby_small.jpg" alt="Reviewer Profile Picture">
                                <h5>Bryan Lam</h5>
                                <h6 class="small">November 23, 2020</h6>
                            </div>
                            <div class="col-8 col-md-9">
                                <div>
                                    <button type="button" class="close" aria-label="Delete Review" title="Delete Review">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="mt-4">
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

