<?php

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Initialise input variables
    $email = $pwd_hashed = $userID = $username = $errorMsg = "";
    $success = true;

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

        // Additional check to make sure e-mail address is well-formed.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match($email_pattern, $email))
        {
            $errorMsg .= "Invalid email format.<br>";
            $success = false;
        }
    }

    // Ensure that password field is filled up
    if (empty($_POST["pwd"])) 
    {
        $errorMsg .= "Password is required.<br>";
        $success = false;
    }
    elseif (strlen($_POST["pwd"]) < 8)
    {
        $errorMsg .= "Password must contain at least 8 characters.<br>";
        $success = false;
    }

    if ($success)
    {
        authenticateUser();
    }

    unset($email);
    unset($userID);
    unset($pwd_hashed);
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
    global $email, $pwd_hashed, $userID, $username, $errorMsg, $success;
    
    require "connect_database.php";

    if ($success)
    {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        require "handle_sql_execute_failure.php";
        $conn->close();

        // Email field is unique so there should only be one row in the result set
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $userID = $row["userID"];
            $pwd_hashed = $row["password"];
            $username = $row["username"];

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
    }

    // Log user in
    if ($success)
    {
        /*
        require 'Zebra_Session.php';
        $session = new Zebra_Session($conn, 'sEcUr1tY_c0dE');
        */
        session_start();

        $_SESSION["loggedin"] = true;
        $_SESSION["userID"] = $userID;
        print_r($_SESSION);
    }
}

?>

<html lang="en">
    <head>
        <title>Login Results</title>
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
                echo "<h1 class='display-4 mt-3'>Login Successful</h1>";
                echo "<h4>Welcome back, $username.</h4>";
                echo '<a class="btn btn-success my-4" href="index.php" role="button">Return to Home</a>';
            }
            else
            {
                require "error_msg.php";
                echo '<a class="btn btn-danger my-4" href="login.php" role="button">Return to Login page</a>';
                echo '</div>';
            }
            ?>
        </main>
        <?php
            include "footer.inc.php";
            unset($username, $errorMsg);
        ?>
    </body>
</html>