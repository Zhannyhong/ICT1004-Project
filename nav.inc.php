
<!-- Custom CSS -->
<link rel="stylesheet" href="css/nav_style.css">

<!-- Left side of the navigation bar -->
<div class="topnav" id="myTopnav" role="navigation">
    <a class="nav-brand" href="index.php" title="Popcorn Movies&Reviews">
        <img class="logo" src="images/logo.gif" alt="Popcorn Logo"/>
        <label id="menu" class="nav-menu"></label>
    </a>
    <a class="btn" href="index.php" title="Home"><i class="fa fa-home"></i> Home</a>
    <a class="btn" href="about_us.php" title="About Us"><i class="fa fa-users"></i> About Us</a>
    <a id="loginIcon" class="nav-right-2" title="Account" href="login.php">
        <?php
        session_start();

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
            echo "<style>.topnav a.nav-right-2{ margin-top: 9px;} </style>";

            unset($profile_pic);
        } else {
            echo "<i class='fas fa-user-circle fa-10x' style='font-size:2.5rem;'></i>";
            echo "<label id='login' style='font-size: 2rem; margin-left: 5px; color: black'></label>";
            
        }
        ?>
        <!-- account_circle -->
    </a>
    <!-- Search bar -->
    <form class="nav-form-right" action="search_results.php" method="post">
        <div class="input-group input-group-lg" id="search">
            <div class="input-group-prepend">
                <button class="input-group-text" type="submit" alt="Search">
                    <i class="material-icons d-inline-block align-middle">search</i>
                </button>
            </div>
            <input required type="text" name="search_input" maxlength="40" class="form-control mr-sm-2" placeholder="Search for movie title" aria-label="Search" aria-describedby="search">
        </div>
    </form>

    <a href="javascript:void(0);" class="icon" onclick="myFunction()" title="Menu">
        <i class="fa fa-bars" style="color: black"></i>
    </a>

</div>
