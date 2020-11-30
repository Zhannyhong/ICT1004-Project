
<nav class="navbar navbar-expand-sm navbar-light" style="background-color: #FFD899;">
    <a class="navbar-brand" href="index.php">
        <img src="images/popcorn.svg" class="d-inline-block align-top" width="75px" height="75px" alt="Popcorn Logo">
    </a>

    <!-- Hamburger Menu for small screens -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarToggler">
        <!-- Left side of the navigation bar -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" title="Home" href="index.php">
                    <i class="material-icons d-inline-block align-middle" style="font-size:35px;">home</i>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" title="About Us" href="about_us.php">About Us</a>
            </li>
        </ul>

        <!-- Right side of the navigation bar -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <!-- Search movies functionality -->
                <form class="form-inline d-inline-block align-middle" action="search_results.php" method="post">
                    <div class="input-group" id="search">
                        <div class="input-group-prepend">
                            <button class="input-group-text" type="submit">
                                <i class="material-icons d-inline-block align-middle">search</i>
                            </button>
                        </div>
                        <input required type="text" name="search_input" maxlength="40" class="form-control mr-sm-2" placeholder="Search for movie title" aria-label="Search" aria-describedby="search">
                    </div>
                </form>
            </li>

            <li class="nav-item">
                <a class="nav-link" title="Account" href="login.php">
                    <?php
                        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"])
                        {
                            $profile_pic = "";
                            $userID = $_SESSION["userID"];
                            require "connect_database.php";

                            // Retrieves user info from database
                            $stmt = $conn->prepare("SELECT profilePic FROM users WHERE userID=?");
                            $stmt->bind_param("s", $userID);
                            require "handle_sql_execute_failure.php";
                            $conn->close();

                            $profile_pic = $result->fetch_assoc()["profilePic"];

                            echo "<img class='profile-logo d-inline-block align-middle' src='$profile_pic' alt='Profile Picture'>";

                            unset($profile_pic);
                        }
                        else
                        {
                            echo "<i class='material-icons d-inline-block align-middle' style='font-size:35px;'>account_circle</i>";
                        }
                    ?>
                </a>
            </li>
        </ul>
    </div>
</nav>
