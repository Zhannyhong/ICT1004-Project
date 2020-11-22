<?php
session_start();

// Checks if the user is logged in
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"])
{
    // Redirects user to their profile page
    header("location: profile_page.php");
    exit();
}


$email = $pwd_hashed = $username = $profile_pic = $userID = $errorMsg = "";
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
        // Additional check to make sure e-mail address is well-formed.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match($email_pattern, $email))
        {
            $errorMsg .= "Invalid email format.";
            $success = false;
        }
    }
    
    if (empty($_POST["pwd"])) 
    {
        $errorMsg .= "Password is required.<br>";
        $success = false;
    }

    if ($success)
    {
        authenticateUser();
    }
}
else
{
    echo "<h2>This page is not to be run directly.</h2>";
    echo "<p>You can register at the link below:</p>";
    echo "<a href='login.php'>Go to Login page...</a>";
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

//Helper function to authenticate the login.
function authenticateUser()
{
    global $email, $username, $userID, $profile_pic, $pwd_hashed, $errorMsg, $success;
    
    // Create database connection.
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    
    // Check connection
    if ($conn->connect_error)
    {
        $conn->close();
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    }
    else
    {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Note that email field is unique, so should only have one row in the result set.
        if ($result->num_rows == 1)
        {
            $row = $result->fetch_assoc();
            $userID = $row["userID"];
            $username = $row["username"];
            $profile_pic = $row["profilePic"];
            $pwd_hashed = $row["password"];
            $stmt->close();
            
            // Check if the password matches
            if (!password_verify($_POST["pwd"], $pwd_hashed))
            {
                $errorMsg = "Email not found or password doesn't match.";
                $success = false;
            }
        }
        else
        {   
            $errorMsg = "Email not found or password doesn't match.";
            $success = false;
        }

        // Log user in
        if ($success)
        {
            require 'Zebra_Session.php';
            $session = new Zebra_Session($conn, 'sEcUr1tY_c0dE');

            $_SESSION["loggedin"] = true;
            $_SESSION["email"] = $email;
            $_SESSION["username"] = $username;
            $_SESSION["profile_pic"] = $profile_pic;
            $_SESSION["userID"] = $userID;
        }

        $conn->close();
    }
}
?>

<html lang="en">
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
            <hr>
            <?php
            if ($success)
            {
                echo "<h2>Login successful!</h2>";
                echo "<p>Welcome back, $username</p>";
                echo '<a class="btn btn-success mb-3" href="index.php" role="button">Return to Home</a>';
                echo "<br>";
            }
            else
            {
                echo "<h4>The following input errors were detected:</h4>";
                echo "<p>" . $errorMsg . "</p>";
                echo '<a class="btn btn-danger mb-3" href="login.php" role="button">Return to Login page</a>';
            }

            unset($email);
            unset($profile_pic);
            unset($pwd_hashed);
            unset($errorMsg);
            unset($success);
            ?>
        </main>
        <?php
            include "footer.inc.php";
        ?>
    </body>
</html>