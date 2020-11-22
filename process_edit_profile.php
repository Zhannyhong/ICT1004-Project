<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["loggedin"]) && $_SESSION["loggedin"])
{
    // Create database connection
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

    // Check connection
    if ($conn->connect_error)
    {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    }

    $userID = $_SESSION["userID"];
    $username = $_SESSION["username"];
    $pwd_hashed = $errorMsg = "";
    $success = true;

    // Use back profile picture if user did not upload any image
    if (($_FILES['file_upload']["error"] == 4))
    {
        $file_upload = $_SESSION["profile_pic"];
    }
    // Error occurred during uploading process
    elseif (($_FILES['file_upload']['error']) != 0)
    {
        $file_err_num = $_FILES['file_upload']['error'];
        $errorMsg .= "File upload error [error $file_err_num].<br>";
        $success = false;
    }
    else
    {
        $allowed_extensions = array("jpeg", "jpg", "png");
        $file_extension = strtolower(pathinfo($_FILES['file_upload']['name'], PATHINFO_EXTENSION));

        // Checks the file signature to ensure that it is an image
        if (exif_imagetype($_FILES['image_upload']['tmp_name']) == false)
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

        // User profile pics will be saved under images/profile_pics/<username>.<file_extension>
        $target_dir = "images/profile_pics/";
        $filename = $username . strtolower(pathinfo($_FILES['file_upload']['name'], PATHINFO_EXTENSION));
        $file_upload = $target_dir . $filename;
    }


    if (!empty($_POST["username"]))
    {
        $username = sanitize_input($_POST["username"]);

        // Check if new username has already been used
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
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
            $stmt = $conn->prepare("SELECT * FROM users WHERE userID=?");
            $stmt->bind_param("s", $userID);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            if (!password_verify($_POST["new_pwd"], $result["password"]))
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
                    // Validate new password
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
}
else
{
    // Redirects user back to sign in page
    echo "<h2>This page is not to be run directly.</h2>";
    echo "<h2>Please<a href='login.php'> sign in </a>first</h2>";
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

    if ($success)
    {
        if ($pwd_hashed == "")
        {
            // User does not update password
            $stmt = $conn->prepare("UPDATE users SET username=?, profilePic=? WHERE userID=?");
            $stmt->bind_param("sss", $username, $file_upload, $userID);
        }
        else
        {
            // Update user profile details in database
            $stmt = $conn->prepare("UPDATE users SET username=?, profilePic=?, password=? WHERE userID=?");
            $stmt->bind_param("ssss", $username, $file_upload, $pwd_hashed, $userID);
        }

        if (!$stmt->execute())
        {
            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $success = false;
        }
        // If user data successfully updated in database
        else
        {
            // If user wants to change their profile picture
            if ($file_upload)
        }


        $stmt->close();
    }
}
?>

<html>
    <head>
        <title>Edit Profile Results</title>
        <?php
        include "head.inc.php";
        ?>
    </head>
    <body>
        <?php
        include "nav.inc.php";
        ?>
            <main class="container">
                <hr/>
                <?php
                if ($success)
                {
                    echo "<h2>Profile updated!</h2>";
                    echo '<a class="btn btn-success mb-3" href="profile_page.php" role="button">Return to Profile page</a>';
                    echo "<br>";
                }
                else
                {
                    echo "<h4>The following input errors were detected:</h4>";
                    echo "<p>" . $errorMsg . "</p>";
                    echo '<a class="btn btn-danger mb-3" href="profile_page.php" role="button">Return to Profile page</a>';
                }
                ?>
            </main>
        <?php
        include "footer.inc.php";
        ?>
    </body>
</html>
