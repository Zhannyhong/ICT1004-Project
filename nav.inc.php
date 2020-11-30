
<!-- Custom CSS -->
<link rel="stylesheet" href="css/nav_style.css">

<!-- Left side of the navigation bar -->
<div class="topnav" id="myTopnav">
    <a class="nav-brand" href="index.php">
        <img src="images/logo.gif" alt="Popcorn Logo"/>
    </a>
    <a class="btn" href="index.php"><i class="fa fa-home"></i> Home</a>
    <a class="btn" href="about_us.php"><i class="fa fa-users"></i> About Us</a>
    
    <a class="nav-right-2" title="Account" href="login.php">
        <?php
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]) {
            $profile_pic = "";
            $userID = $_SESSION["userID"];
            require "connect_database.php";

            // Retrieves user info from database
            $stmt = $conn->prepare("SELECT profilePic FROM users WHERE userID=?");
            $stmt->bind_param("s", $userID);
            require "handle_sql_execute_failure.php";
            $conn->close();

            $profile_pic = $result->fetch_assoc()["profilePic"];

            echo "<img class='profile-logo' src='$profile_pic' alt='Profile Picture'>";

            unset($profile_pic);
        } else {
            echo "<i class='fas fa-user-circle' style='font-size:46px;'></i>";
        }
        ?>
        <!-- account_circle -->
    </a>
    <!-- Search movies functionality -->
        <form class="nav-form-rigth" action="search_results.php" method="post">
            <div class="input-group" id="search">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="material-icons d-inline-block align-middle">search</i>
                    </span>
                </div>
                <input required type="text" name="search_input" maxlength="40" class="form-control mr-sm-2" placeholder="Search for movie title" aria-label="Search" aria-describedby="search">
            </div>
        </form>
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <i class="fa fa-bars"></i>
    </a>
    
</div>
