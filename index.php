
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
    <body class="d-flex flex-column min-vh-100" style="background: #f5f5f5;">
        <?php
        session_start();
        include "nav.inc.php";
        ?>

        <!-----Main----->
        <main id="main-container" class="content flex-grow-1">
            <?php
            include "carousel.inc.php";
            include "movie_list.GridView.php";
            ?>
        </main>
        <?php
        include "footer.inc.php";
        ?>
    </body>
</html>