<?php

// Create database connection
$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

// Check connection
if ($conn->connect_error)
{
    $errorMsg = "Connection failed: " . $conn->connect_error;
    $success = false;
}


$email = $username = $file_upload = $pwd_hashed = $errorMsg = "";
$success = true;

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
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
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows == 1)
        {
            $errorMsg .= "Popcorn account already exists.<br>";
            $success = false;
        }

        // Additional check to make sure e-mail address is well-formed.
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match($email_pattern, $email))
        {
            $errorMsg .= "Invalid email format.";
            $success = false;
        }
    }

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


    // Use default profile picture if user did not upload any image
    if (($_FILES['file_upload']["error"] == 4))
    {
        $file_upload = "images/profile_pics/default_profile_pic.png";
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
    }
    $pwd_hashed = password_hash($_POST["pwd"], PASSWORD_DEFAULT);

    
    if ($success)
        saveMemberToDB();

    $conn->close();
}
else
{
    echo "<h2>This page is not to be run directly.</h2>";
    echo "<p>You can register at the link below:</p>";
    echo "<a href='register.php'>Go to Register page...</a>";
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

    if ($success)
    {
        // Get current datetime in UNIX format
        date_default_timezone_set('Asia/Singapore');
        $curr_datetime = date('Y-m-d H:i:s');

        // Saves new user to database
        $stmt = $conn->prepare("INSERT INTO users (email, username, profilePic, password, joinDate) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $email, $username, $file_upload, $pwd_hashed, $curr_datetime);

        if (!$stmt->execute())
        {
            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $success = false;
        }
        // If user successfully saved to database and user uploaded their own profile picture
        elseif ($_FILES['file_upload']["error"] != 4)
        {
            // Save user's new profile picture to database
            if (!copy($_FILES["file_upload"]["tmp_name"], $file_upload))
            {
                $errorMsg = "File upload failed.";
                $success = false;
            }
        }

        $stmt->close();
    }
}
?>

<html>
    <head>
        <title>Registration Results</title>
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
                echo "<h2>Registration successful!</h2>";
                echo "<p>Email: $email</p>";
                echo "<p>Thank you for signing up, $username</p>";
                echo '<a class="btn btn-success mb-3" href="login.php" role="button">Login</a>';
                echo "<br>";
            }
            else
            {
                echo "<h4>The following input errors were detected:</h4>";
                echo "<p>" . $errorMsg . "</p>";
                echo '<a class="btn btn-danger mb-3" href="register.php" role="button">Return to Register page</a>';
            }
            ?>
        </main>
        <?php
            include "footer.inc.php";
        ?>
    </body>
</html>