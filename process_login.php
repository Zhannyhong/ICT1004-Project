<?php

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
            global $fname, $lname, $email, $pwd_hashed, $errorMsg, $success;    
            
            // Create database connection.    
            $config = parse_ini_file('../../private/db-config.ini');    
            $conn = new mysqli($config['servername'], $config['username'],            
                    $config['password'], $config['dbname']);   
            
            // Check connection    
            if ($conn->connect_error)    
            {       
                $errorMsg = "Connection failed: " . $conn->connect_error;        
                $success = false;     
            }    
            else    
            {        
                // Prepare the statement:        
                $stmt = $conn->prepare("SELECT * FROM users WHERE
                        email=?");   

                // Bind & execute the query statement:        
                $stmt->bind_param("s", $email);       
                $stmt->execute();        
                $result = $stmt->get_result();        
                if ($result->num_rows > 0)        
                {            
                    // Note that email field is unique, so should only have            
                    // one row in the result set.            
                    $row = $result->fetch_assoc();            
                    $fname = $row["fname"];            
                    $lname = $row["lname"];            
                    $pwd_hashed = $row["password"];     
                    $stmt->close();    
                    $conn->close();
                    // Check if the password matches:            
                    if (!password_verify($_POST["pwd"], $pwd_hashed))            
                    {                
                        // Don't be too specific with the error message - hackers don't   
                        // need to know which one they got right or wrong. :)                
                        $errorMsg = "Email not found or password doesn't match...";               
                        $success = false;            
                       
                    }       
                    
                }        
                else       
                {            
                    $errorMsg = "Email not found or password doesn't match...";            
                    $success = false;        
                        
                }        
                    
            }    
            
        }
        $pwd = "";
        $pwd_hashed = "";
        unset($pwd);
        unset($pwd_hashed);
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
                echo "<h1 class='display-4'>Login successful</h1>";
                echo "<h4>Welcome back, $username.</h4>";
                echo '<a class="btn btn-success mb-3" href="index.php" role="button">Return to Home</a>';
            }
            else
            {
                echo "<h1 class='display-4'>Oops!</h1>";
                echo "<h3>The following input errors were detected:</h3>";
                echo "<p class='text-secondary'>" . $errorMsg . "</p>";
                echo '<a class="btn btn-danger mb-3" href="login.php" role="button">Return to Login page</a>';
            }
            ?>
        </main>
        <?php
            include "footer.inc.php";
        ?>
    </body>
</html>