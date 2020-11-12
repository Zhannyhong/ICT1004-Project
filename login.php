<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>World of Pets</title>
        <?php
            include "head.inc.php";
        ?>
    </head>
    <body>
        <?php
            include "nav.inc.php";
        ?>
        <main class="container">
            <h1>Member Login</h1>
            <p>
                Existing members log in here. For new members, please go to the
                <a href="register.php">Sign Up page</a>.
            </p>
            <form action="process_login.php" method="post">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input class="form-control" type="email" pattern="^[a-z0-9._%+-]+@[a-z0-9._%+-]+\.(com|edu|sg)$"
                        id="email" required name="email" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input class="form-control" type="password" id="pwd"
                        required name="pwd" placeholder="Enter password">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </form>
        </main>
        <?php
            include "footer.inc.php";
        ?>
    </body>
</html>