<html lang="en">    
    <head>
        <?php
            include "head.inc.php";
        ?>
        <title>Edit Profile</title>
    </head>
    <body>
        <?php
        include "nav.inc.php";
        ?>
        <main class="container">
            <h1>Edit Profile</h1>
            <hr>
            <div class="col-md-3 spacing">
                <img src="images/tabby_large.jpg" class="avatar">
                <h6 class="spacing">Upload a different photo...</h6>
                <input type="file" class="form-control">
            </div>
           
            <div class="col-md-9 spacing">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="username">New Username:</label>
                        <input class="form-control" type="text" id="username"
                               maxlength="45" name="username" placeholder="Enter username">
                    </div>
                    <div class="form-group">
                        <label for="old_pwd">Old Password:</label>
                        <input class="form-control" type="password" id="old_pwd"
                               required name="old_pwd" placeholder="Enter old password">
                    </div>
                    <div class="form-group">
                        <label for="pwd">New Password:</label>
                        <input class="form-control" type="password" id="pwd"
                               required name="pwd" placeholder="Enter new password">
                    </div>
                    <div class="form-group">
                        <label for="pwd_confirm">Confirm Password:</label>
                        <input class="form-control" type="password" id="pwd_confirm" 
                               required name="pwd_confirm" placeholder="Confirm Password">
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Save Changes</button>
                    </div>
                </form>
            </div>
        </main>
        
        <?php
        include "footer.inc.php";
        ?>
    </body>
</html>