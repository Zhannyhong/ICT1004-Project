<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$fname = $lname = $email = $pwd_hashed = $errorMsg = "";
$success = true;

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    // if first name not empty
    if (!empty($_POST["fname"]))
    {
        $fname = sanitize_input($_POST["fname"]);
    }
    
    if (empty($_POST["lname"]))
    {
        $errorMsg .= "Last name is required.<br>";
        $success = false;
    }
    else
    {
        $lname = sanitize_input($_POST["lname"]);
    }
    
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
    
    if (empty($_POST["pwd"]) || empty($_POST["pwd_confirm"])) 
    {
        $errorMsg .= "Password and confirmation required.<br>";
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
            $pwd_hashed = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
        }
    }
    
    if (!isset($_POST["agree_check"]))
    {
        $errorMsg .= "Agreeing to terms and conditions is required.<br>";
        $success = false;
    }
    
    if ($success)
    {
        saveMemberToDB();
    }
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
        $stmt = $conn->prepare("INSERT INTO world_of_pets_members (fname, lname, email, password) VALUES (?, ?, ?, ?)");
        
        // Bind & execute the query statement:
        $stmt->bind_param("ssss", $fname, $lname, $email, $pwd_hashed);
        if (!$stmt->execute())
        {   
            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $success = false;
        }
        $stmt->close();
    }
    
    $conn->close();
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
            <hr>
            <?php
            if ($success)
            {
                echo "<h2>Registration successful!</h2>";
                echo "<p>Email: " . $email;
                echo "<p>Thank you for signing up, " . $fname . " " . $lname . "</p>";
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