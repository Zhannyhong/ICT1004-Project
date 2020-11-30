<!DOCTYPE html>

<html lang="en">
    <head>
        <title>Registration Page</title>
        <?php
            include "head.inc.php";
        ?>
    </head>
    <body class="d-flex flex-column min-vh-100">
        <?php
            include "nav.inc.php";
        ?>
        <main class="container flex-grow-1">
            <div class="my-5">
                <h1 class="display-4">The show is just starting</h1>
                <h6 class="lead">Create a free account to share your movie reviews with the Popcorn community.</h6>
                <h6 class="lead">Already have a Popcorn account? <a href="login.php">Log in here</a>.</h6>
            </div>

            <form action="process_register.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input required class="form-control" type="email" pattern="^[a-z0-9._%+-]+@[a-z0-9._%+-]+\.(com|edu|sg)$"
                        id="email" name="email" placeholder="Enter email">
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label for="username">Username</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">@</div>
                            </div>
                            <input required class="form-control" type="text" id="username" name="username" placeholder="Enter username" maxlength="30" pattern="[a-zA-Z0-9]+">
                        </div>
                        <small class="form-text text-muted">
                            Username must be unique and contain no more than 30 alphanumeric characters.
                        </small>
                    </div>
                    <div class="form-group col">
                        <label for="file_upload">Choose Profile Picture</label>
                        <input type="file" class="form-control-file" name="file_upload" accept=".jpeg, .jpg, .png">
                    </div>
                </div>

                <div class="form-group">
                    <label for="pwd">Password</label>
                    <input required class="form-control" type="password" id="pwd" name="pwd" minlength="8" placeholder="Enter password">
                    <small class="form-text text-muted">
                        Your password must be at least 8 characters long, contain upper and lowercase letters, and include numbers.
                    </small>
                </div>
                <div class="form-group">
                    <label for="pwd_confirm">Confirm Password</label>
                    <input required class="form-control" type="password" id="pwd_confirm" name="pwd_confirm" minlength="8" placeholder="Re-enter password">
                </div>
                <div class="form-group">
                    <p class="small text-muted mb-1">By clicking on the "Sign Me Up!" button below, you agree to Popcorn's Terms of Use and Privacy Policy.</p>
                    <button class="btn btn-primary" type="submit">Sign Me Up!</button>
                </div>
            </form>
        </main>
        <?php
            include "footer.inc.php";
        ?>
    </body>
</html>