<?php

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Initialise input variables
    $email = $username = $file_upload = $pwd_hashed = $errorMsg = "";
    $success = true;

    require "connect_database.php";

    // Sanitise and validate email input
    if (empty($_POST["email"]))
    {
        $errorMsg .= "Email is required.<br>";
        $success = false;
    }
    else
    {
        $email = sanitize_input($_POST["email"]);
        $email_pattern = '/^[a-z0-9._%+-]+@[a-z0-9.-]+\.(com|edu|sg)$/m';

        // Check if email has already been used
        $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        require "handle_sql_execute_failure.php";

        if ($result->num_rows == 1)
        {
            $errorMsg .= "Popcorn account already exists.<br>";
            $success = false;
        }

        // Additional check to make sure e-mail address is well-formed
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match($email_pattern, $email))
        {
            $errorMsg .= "Invalid email format.<br>";
            $success = false;
        }
    }


    // Sanitise and validate username input
    if (empty($_POST["username"]))
    {
        $errorMsg .= "Username is required.<br>";
        $success = false;
    }
    else
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


    // Sanitise and validate file uploaded
    if (($_FILES['file_upload']['error']) == UPLOAD_ERR_NO_FILE)
    {
        // If user did not upload any files, use default profile picture
        $file_upload = "images/default_profile_pic.png";
    }
    elseif (($_FILES['file_upload']['error']) != UPLOAD_ERR_OK)
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


    // Sanitise and validate both password inputs
    if (empty($_POST["pwd"]) || empty($_POST["pwd_confirm"])) 
    {
        $errorMsg .= "Password and confirmation is required.<br>";
        $success = false;
    }
    else 
    {
        if ($_POST["pwd"] != $_POST["pwd_confirm"])
        {
            $errorMsg .= "Passwords do not match.<br>";
            $success = false;
        }
        else
        {
            if (strlen($_POST["pwd"]) < 8)
            {
                $errorMsg .= "Password must contain at least 8 characters.<br>";
                $success = false;
            }
            if (!preg_match("#[0-9]+#", $_POST["pwd"]))
            {
                $errorMsg .= "Password must contain at least 1 number.<br>";
                $success = false;
            }
            if (!preg_match("#[a-z]+#", $_POST["pwd"]))
            {
                $errorMsg .= "Password must contain at least 1 lowercase letter.<br>";
                $success = false;
            }
            if (!preg_match("#[A-Z]+#", $_POST["pwd"]))
            {
                $errorMsg .= "Password must contain at least 1 uppercase letter.<br>";
                $success = false;
            }
        }

        $pwd_hashed = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
    }

    if ($success)
    {
        saveMemberToDB();
    }

    unset($file_upload, $email_pattern, $file_err_num, $file_extension, $file_upload, $result);
    $conn->close();
}
else
{
    require "illegal_access.php";
    echo '<a class="btn btn-danger my-4" href="register.php" role="button">Register Here</a>';
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
function saveMemberToDB()
{
    global $conn, $email, $username, $file_upload, $pwd_hashed, $errorMsg, $success;

    // Formats image SRC to be uploaded to database
    $encoded_file = base64_encode(file_get_contents($file_upload));
    $file_mime = mime_content_type($file_upload);
    $profile_pic = "data:" . $file_mime . ";base64," . $encoded_file;

    // Get current datetime in UNIX format
    date_default_timezone_set('Asia/Singapore');
    $curr_datetime = date('Y-m-d H:i:s');

    // Saves new user to database
    $stmt = $conn->prepare("INSERT INTO users (email, username, profilePic, password, joinDate) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $email, $username, $profile_pic, $pwd_hashed, $curr_datetime);
    require "handle_sql_execute_failure.php";

}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Registration Results</title>
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
                echo "<img src='images/check.svg' class='mt-5' width='125' height='125' alt='Success'>";
                echo "<h1 class='display-4 mt-3'>Registration Successful</h1>";
                echo "<h5>Email: $email</h5>";
                echo "<h5>Thank you for signing up, $username.</h5>";
                echo '<a class="btn btn-success my-4" href="login.php" role="button">Login</a>';
            }
            else
            {
                require "error_msg.php";
                echo '<a class="btn btn-danger my-4" href="register.php" role="button">Return to Register page</a>';
                echo "</div>";
            }
            ?>
        </main>
        <?php
            include "footer.inc.php";
            unset($username, $email, $errorMsg);
        ?>
    </body>
</html>