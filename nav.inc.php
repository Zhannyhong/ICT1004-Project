<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <a class="navbar-brand" href="#">
        <img src="images/popcorn.svg" alt="LOGO"/>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mobile-navbar-toggler" aria-controls="mobile-navbar-toggler" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mobile-navbar-toggler">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" title="Home" href="index.php">
                    <i class="material-icons d-inline-block align-middle">home</i>
                </a>
            </li>
            </li>
            <li class="nav-item">
                <a class="nav-link" title="Movie" href="movie_template.php">
                    <i class="material-icons d-inline-block align-middle">movie</i>
                </a>
            </li>
            <li>
                <a class="nav-link" title="About Us" href="about_us.php">About Us</a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" title="Sign In" href="profile_page.php">
                    <i class="material-icons d-inline-block align-middle">account_circle</i>
                </a>
            </li>
            <form class="form-inline">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="material-icons d-inline-block align-middle">search</i>
                        </span>
                    </div>
                    <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
                </div>
            </form>
        </ul>
    </div>
</nav>