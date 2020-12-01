<?php
/*
  require 'Zebra_Session.php';
  $config = parse_ini_file('../../private/db-config.ini');
  $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
  $session = new Zebra_Session($conn, 'sEcUr1tY_c0dE');
 */
session_start();
print_r($_SESSION);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Popcorn Homepage</title>
        <?php
        include "head.inc.php";
        ?>
        <!-- Custom JS -->
        <script defer src="js/main.js"></script>
    </head>
    <body class="d-flex flex-column min-vh-100">
        <?php
        include "nav.inc.php";
        ?>

        <!-----Main----->
        <main id="main-container" class="content flex-grow-1">
            <?php
            include "carousel.inc.php";
            ?>
            <?php
            include "movie_list.GridView.php";
            ?>
        </main>
        <?php
        include "footer.inc.php";
        ?>
    </body>
</html>