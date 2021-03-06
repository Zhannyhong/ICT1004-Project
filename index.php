
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
    <main class="d-flex flex-column min-vh-100 text-center" style="background: #f5f5f5;">
        <?php
        session_start();
        include "nav.inc.php";
        ?>

        <!-- Main -->
        <div class="content">
                <?php
                include "carousel.inc.php";
                include "movie_list.GridView.php";
                ?>
                
        </div>
        <?php
        include "footer.inc.php";
        ?>
    </main>
</html>