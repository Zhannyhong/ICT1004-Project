<?php
session_start();

// Checks if the user is logged in
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"])
{
    // Initialise input variables
    $email = $username = $profile_pic = $errorMsg = "";
    $userID = $_SESSION["userID"];
    $success = true;

    require "connect_database.php";

    // Retrieves user info from database
    $stmt = $conn->prepare("SELECT * FROM users WHERE userID=?");
    $stmt->bind_param("s", $userID);
    require "handle_sql_execute_failure.php";
    $conn->close();


    $user_details = $result->fetch_assoc();
    $username = $user_details["username"];
    $email = $user_details["email"];
    $profile_pic = $user_details["profilePic"];
}
else
{
    // Redirects user back to sign in page
    echo "<h2>This page is not to be run directly.</h2>";
    echo "<h2>Please<a href='login.php'> sign in </a>first</h2>";
    exit();
}

?>

<html lang="en">
    <head>
        <?php
            include "head.inc.php";
        ?>
        <title>Edit Profile</title>
    </head>
    <body>
        <?php
        include "nav.inc.php";
        ?>
        <main class="container">
            <h1 class="display-4 mt-4">Edit Profile</h1>
            <hr>
           
            <div>
                <form action="process_edit_profile.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-5 col-md-3 text-center" id="change-pic">
                            <img class="avatar" src="<?=$profile_pic?>" alt="Profile Picture">
                            <h5><?=$username?></h5>
                            <h6><?=$email?></h6>
                        </div>
                        <div class="col-sm-7 col-md-9 my-4">
                            <div class="form-group">
                                <label for="file_upload">Change Profile Picture</label>
                                <input type="file" class="form-control-file" name="file_upload" accept=".jpeg, .jpg, .png">
                            </div>
                            <div class="form-group">
                                <label for="username">New Username</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">@</div>
                                    </div>
                                    <input class="form-control" type="text" id="username" name="username" placeholder="Enter new username" maxlength="30">
                                </div>
                                <small class="form-text text-muted">
                                    Username must be unique and contain no more than 30 alphanumeric characters.
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="old_pwd">Old Password</label>
                                <input class="form-control" type="password" id="old_pwd" name="old_pwd" minlength="8" placeholder="Enter old password">
                                <small class="form-text text-muted">
                                    You have to enter your old password before you can change your password.
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="pwd">New Password</label>
                                <input class="form-control" type="password" id="pwd" name="new_pwd" minlength="8" placeholder="Enter new password">
                                <small class="form-text text-muted">
                                    Your password must be at least 8 characters long, contain upper and lowercase letters, and include numbers.
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="pwd_confirm">Confirm Password</label>
                                <input class="form-control" type="password" id="pwd_confirm" name="pwd_confirm" minlength="8" placeholder="Re-enter new password">
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>
        
        <?php
        include "footer.inc.php";
        unset($email, $errorMsg, $profile_pic, $result, $success, $userID, $user_details, $username);
        ?>
    </body>
</html>