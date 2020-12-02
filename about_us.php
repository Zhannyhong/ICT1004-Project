<?php
/*
require 'Zebra_Session.php';
$session = new Zebra_Session($conn, 'sEcUr1tY_c0dE');
*/
session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            include "head.inc.php";
        ?>
        <title>About Us</title>
    </head>

    <body class="d-flex flex-column min-vh-100">
        <?php
            include "nav.inc.php";
        ?>
        <header class="jumbotron text-center">
            <h1 class="display-4">About Us</h1>
            <span class="subhead">WHAT WE DO</span>
            <p class="lead">
                We are the world's most trusted recommendation resource for quality entertainment. At Popcorn,
                you can find the stuff you love, or share your candid opinions with other avid movie watchers. If you
                are just a casual movie binger, or a serious movie critic, you have come to the right place!
            </p>
        </header>

        <main class="container flex-grow-1">
            <div>
                <h2 class="display-4 font-weight-light">Meet the Team</h2>
                <p class="font-italic">The ones that made it all possible.</p>

            </div>

            <div class="row text-center">
                <article class="col-sm-6">
                    <div class="card-background rounded shadow-sm">
                        <img class="avatar" src="images/Anne.jpeg" alt="Anne's Avatar">
                        <h3 class="mb-0">Anne Tan</h3>
                        <h4 class="small">Project Lead</h4>
                        <a href="mailto:2002716@sit.singaporetech.edu.sg" title="Send me an email!">
                            <i class="material-icons">email</i>
                        </a>
                    </div>
                </article>

                <article class="col-sm-6">
                    <div class="card-background rounded shadow-sm">
                        <img class="avatar" src="images/Jessica.jpg" alt="Jessica's Avatar">
                        <h3 class="mb-0">Jessica Tan</h3>
                        <h4 class="small">Project Lead</h4>
                        <a href="mailto:2002253@sit.singaporetech.edu.sg" title="Send me an email!">
                            <i class="material-icons">email</i>
                        </a>
                    </div>
                </article>
            </div>
            <div class="row text-center">
                <article class="col-sm-6">
                    <div class="card-background rounded shadow-sm">
                        <img class="avatar" src="images/ZhanHong.jpg" alt="Zhan Hong's Avatar">
                        <h3 class="mb-0">Lee Zhan Hong</h3>
                        <h4 class="small">Project Lead</h4>
                        <a href="mailto:2003116@sit.singaporetech.edu.sg" title="Send me an email!">
                            <i class="material-icons">email</i>
                        </a>
                    </div>
                </article>

                <article class="col-sm-6">
                    <div class="card-background rounded shadow-sm">
                        <img class="avatar" src="images/Bryan.jpeg" alt="Bryan's Avatar">
                        <h3 class="mb-0">Bryan Lam</h3>
                        <h4 class="small">Project Lead</h4>
                        <a href="mailto:2003114@sit.singaporetech.edu.sg" title="Send me an email!">
                            <i class="material-icons">email</i>
                        </a>
                    </div>
                </article>
            </div>
            <div class="row text-center">
                <article class="col-sm-6">
                    <div class="card-background rounded shadow-sm">
                        <img class="avatar" src="images/YongJun.jpg" alt="Yong Jun's Avatar">
                        <h3 class="mb-0">Lim Yong Jun</h3>
                        <h4 class="small">Project Lead</h4>
                        <a href="mailto:2003119@sit.singaporetech.edu.sg" title="Send me an email!">
                            <i class="material-icons">email</i>
                        </a>
                    </div>
                </article>
            </div>
        </main>
        <?php
            include "footer.inc.php";
        ?>
    </body>
</html>

