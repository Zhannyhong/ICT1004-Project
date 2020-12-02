<?php
session_start();

/* Get current_review_location, which was previously set at either movie_details
or profile_page. */
define("PREVIOUS_LOCATION", $_SESSION['current_review_location']);
echo substr(PREVIOUS_LOCATION, 0, 21);
if (substr(PREVIOUS_LOCATION, 0, 21) === 'movie_details.php?id=')
{
    $_SESSION['login_signup_from'] = PREVIOUS_LOCATION;
} else if (PREVIOUS_LOCATION === 'profile_page.php')
{
    $_SESSION['login_signup_from'] = PREVIOUS_LOCATION;
} else
{
    $_SESSION['login_signup_from'] = '';
}
// Checks if the user is logged in
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"])
{
    // Redirects user to profile page
    header("location: profile_page.php");
    exit();
}

?>

<html lang="en">
    <head>
        <title>Member Login</title>
        <?php
            include "head.inc.php";
        ?>
    </head>
    <body class="d-flex flex-column min-vh-100">
        <?php
            include "nav.inc.php";
        ?>
        <main class="container flex-grow-1">
            <div class="my-5">
                <h1 class="display-4">Welcome Back</h1>
                <h6 class="lead">Need a Popcorn account? <a href="register.php">Create an account</a>.</h6>
            </div>

            <form action="process_login.php" method="post">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input required class="form-control" type="email" pattern="^[a-z0-9._%+-]+@[a-z0-9._%+-]+\.(com|edu|sg)$"
                        id="email" name="email" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="pwd">Password</label>
                    <input required class="form-control" type="password" id="pwd" name="pwd" minlength="8" placeholder="Enter password">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Login</button>
                </div>
            </form>
        </main>
        <?php
            include "footer.inc.php";
        ?>
    </body>
</html>