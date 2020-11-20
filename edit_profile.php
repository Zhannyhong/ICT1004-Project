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
            <h1 class="display-4 mt-4">Edit Profile</h1>
            <hr>
           
            <div>
                <form action="" method="post">
                    <div class="row">
                        <div class="col-sm-5 col-md-3 text-center" id="change-pic">
                            <img src="images/tabby_large.jpg" class="avatar" alt="Profile Picture">
                            <h5>Bryan Lam</h5>
                            <h6>tabby123@gmail.com</h6>
                        </div>
                        <div class="col-sm-7 col-md-9 my-4">
                            <div class="form-group">
                                <label for="file_upload">Change Profile Picture</label>
                                <input type="file" class="form-control-file" name="file_upload">
                            </div>
                            <div class="form-group">
                                <label for="username">New Username</label>
                                <input class="form-control" type="text" id="username" maxlength="45" name="username" placeholder="Enter username">
                            </div>
                            <div class="form-group">
                                <label for="old_pwd">Old Password</label>
                                <input required class="form-control" type="password" id="old_pwd" name="old_pwd" placeholder="Enter old password">
                            </div>
                            <div class="form-group">
                                <label for="pwd">New Password</label>
                                <input required class="form-control" type="password" id="pwd" name="new_pwd" placeholder="Enter new password">
                            </div>
                            <div class="form-group">
                                <label for="pwd_confirm">Confirm Password</label>
                                <input required class="form-control" type="password" id="pwd_confirm" name="pwd_confirm" placeholder="Re-enter new password">
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>
        
        <?php
        include "footer.inc.php";
        ?>
    </body>
</html>