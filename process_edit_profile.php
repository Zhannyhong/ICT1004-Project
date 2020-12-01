<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["loggedin"]) && $_SESSION["loggedin"])
{
    // Initialise input variables
    $username = $file_upload = $pwd_hashed = $errorMsg = "";
    $userID = $_SESSION["userID"];
    $success = true;

    require "connect_database.php";

    // Retrieves user info from database
    $stmt = $conn->prepare("SELECT * FROM users WHERE userID=?");
    $stmt->bind_param("s", $userID);
    require "handle_sql_execute_failure.php";

    $user_details = $result->fetch_assoc();
    $username = $user_details["username"];
    $pwd_hashed = $user_details["password"];


    // Sanitise and validate file uploaded
    if (($_FILES['file_upload']['error']) == UPLOAD_ERR_NO_FILE)
    {
        // If user did not upload any files, use default profile picture
        $file_upload = "images/default_profile_pic.png";
    }
    else if (($_FILES['file_upload']['error']) != UPLOAD_ERR_OK)
    {
        // Error occurred during uploading process
        $file_err_num = $_FILES['file_upload']['error'];
        $errorMsg .= "Error uploading file [error $file_err_num].<br>";
        $success = false;
    }
    else
    {
        $allowed_extensions = array("jpeg", "jpg", "png");
        $file_extension = strtolower(pathinfo($_FILES['file_upload']['name'], PATHINFO_EXTENSION));

        // Checks the file signature to ensure that it is a JPEG or PNG image
        if (exif_imagetype($_FILES['image_upload']['tmp_name'] != IMAGETYPE_JPEG) or exif_imagetype($_FILES['image_upload']['tmp_name'] != IMAGETYPE_PNG))
        {
            $errorMsg .= "File uploaded is not an image.<br>";
            $success = false;
        }

        // Checks that file uploaded is only of the allowed extensions
        if (!in_array($file_extension, $allowed_extensions))
        {
            $errorMsg .= "File uploaded is not a JPEG, JPG, or PNG file.<br>";
            $success = false;
        }

        // Checks that file uploaded is not more than 2MB
        if ($_FILES['file_upload']['size'] > 2097152)
        {
            $errorMsg .= "File uploaded is more than 2MB.<br>";
            $success = false;
        }

        $file_upload = $_FILES["file_upload"]["tmp_name"];
    }


    // Sanitise and validate username input
    if (isset($_POST["username"]) && !empty($_POST["username"]))
    {
        $username = sanitize_input($_POST["username"]);

        // Check if username has already been used
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        require "handle_sql_execute_failure.php";

        if ($result->num_rows == 1)
        {
            $errorMsg .= "Username is already taken.<br>";
            $success = false;
        }
        else
        {
            if (!ctype_alnum($username))
            {
                $errorMsg .= "Username contains non-alphanumeric characters.<br>";
                $success = false;
            }
            if (strlen($username) > 30)
            {
                $errorMsg .= "Username contains more than 30 characters.<br>";
                $success = false;
            }
        }
    }


    // If user wants to change their password
    if (!empty($_POST["old_pwd"]) || !empty($_POST["new_pwd"]) || !empty($_POST["pwd_confirm"]))
    {
        // Ensure that all password fields are filled up first
        if (empty($_POST["old_pwd"]) || empty($_POST["new_pwd"]) || empty($_POST["pwd_confirm"]))
        {
            $errorMsg .= "Password is required.<br>";
            $success = false;
        }
        else
        {
            // Check if old password given is correct
            if (!password_verify($_POST["new_pwd"], $pwd_hashed))
            {
                $errorMsg .= "Incorrect password.<br>";
                $success = false;
            }
            else
            {
                if ($_POST["new_pwd"] != $_POST["pwd_confirm"])
                {
                    $errorMsg .= "New passwords do not match.<br>";
                    $success = false;
                }
                else
                // Additional check to make sure new password is well-formed
                {
                    if (strlen($_POST["new_pwd"]) < 8) {
                        $errorMsg .= "Password must contain at least 8 characters.<br>";
                        $success = false;
                    }
                    if (!preg_match("#[0-9]+#", $_POST["new_pwd"])) {
                        $errorMsg .= "Password must contain at least 1 number.<br>";
                        $success = false;
                    }
                    if (!preg_match("#[a-z]+#", $_POST["new_pwd"])) {
                        $errorMsg .= "Password must contain at least 1 lowercase letter.<br>";
                        $success = false;
                    }
                    if (!preg_match("#[A-Z]+#", $_POST["new_pwd"])) {
                        $errorMsg .= "Password must contain at least 1 uppercase letter.<br>";
                        $success = false;
                    }
                }
            }

            $pwd_hashed = password_hash($_POST["new_pwd"], PASSWORD_DEFAULT);
        }
    }

    if ($success)
        saveProfileChanges();

    $conn->close();
    unset($allowed_extensions, $file_err_num, $file_extension, $file_upload, $pwd_hashed, $result, $userID, $user_details, $username);
}
else
{
    require "illegal_access.php";
    echo '<a class="btn btn-danger my-4" href="login.php" role="button">Login Here</a>';
    echo "</div>";
    echo "</body>";
    include "footer.inc.php";
    exit();
}

//Helper function that checks input for malicious or unwanted content.
function sanitize_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//Helper function to write the member data to the DB
function saveProfileChanges()
{
    global $conn, $userID, $file_upload, $username, $pwd_hashed, $errorMsg, $success;

    // Formats image SRC to be uploaded to database
    $encoded_file = base64_encode(file_get_contents($file_upload));
    $file_mime = mime_content_type($file_upload);
    $profile_pic = "data: " . $file_mime . ";base64," . $encoded_file;
    
    // Update user profile details in database
    $stmt = $conn->prepare("UPDATE users SET username=?, profilePic=?, password=? WHERE userID=?");
    $stmt->bind_param("ssss", $username, $profile_pic, $pwd_hashed, $userID);
    require "handle_sql_execute_failure.php";

    if ($stmt->affected_rows != 1)
    {
        $errorMsg .= "Failed to delete review: (' . $stmt->errno . ') ' . $stmt->error<br>";
    }

}
?>

<html lang="en">
    <head>
        <title>Edit Profile Results</title>
        <?php
        include "head.inc.php";
        ?>
    </head>
    <body class="d-flex flex-column min-vh-100">
        <?php
        include "nav.inc.php";
        ?>
        <main class="container flex-grow-1 text-center">
            <?php
            if ($success)
            {
                echo "<img src='images/check.svg' class='mt-5' width='125px' height='125px' alt='Success'>";
                echo "<h1 class='display-4 mt-3'>Profile Update Successful</h1><br>";
                echo '<a class="btn btn-success my-4" href="profile_page.php" role="button">Return to Profile page</a>';
            }
            else
            {
                require "error_msg.php";
                echo '<a class="btn btn-danger my-4" href="profile_page.php" role="button">Return to Profile page</a>';
                echo "</div>";
            }
            ?>
        </main>
        <?php
        include "footer.inc.php";
        unset($success, $errorMsg);
        ?>
    </body>
</html>
