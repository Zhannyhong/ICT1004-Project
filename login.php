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
            <div class="my-5">
                <h1 class="display-4">Member Login</h1>
                <h6 class="lead">Need a Popcorn account? <a href="register.php">Create an account</a>.</h6>
            </div>

            <form action="process_login.php" method="post">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input required class="form-control" type="email" pattern="^[a-z0-9._%+-]+@[a-z0-9._%+-]+\.(com|edu|sg)$"
                        id="email" name="email" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="pwd">Password</label>
                    <input required class="form-control" type="password" id="pwd" name="pwd" minlength="8" placeholder="Enter password">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Login</button>
                </div>
            </form>
        </main>
        <?php
            include "footer.inc.php";
        ?>
    </body>
</html>