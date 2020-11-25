<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!-- Google Icons -->
<link rel="stylesheet"
      href="https://fonts.googleapis.com/icon?family=Material+Icons">

<!-- Bootstrap CSS -->
<link rel="stylesheet"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity=
    "sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
    crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<style>
    .navbar-custom {
        background-color: #FFD899;;
    }
    nav a {
        color: black;
        font-size: 18px
    }
    nav img {
        border: 1px solid black; 
        width: 70px;
        height: 70px;
    }
    input[nav-item]:hover{
        text-decoration: #1929BC underline;
        font-weight: bold;
    }
    .navbar-toggler{
        width: 47px;
        height: 34px;
        background-color: black;
        border:pink;
    }
    .navbar-toggler .line{
        width: 100%;
        float: left;
        height: 2px;
        background-color: #fff;
        margin-bottom: 5px;
    }
</style>


<nav class="navbar navbar-expand-sm navbar-custom">
    <a class="navbar-brand" href="index.php">
        <img src="images/popcorn.svg" alt="LOGO"/>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mobile-navbar-toggler" aria-controls="mobile-navbar-toggler" aria-expanded="false" aria-label="Toggle navigation">
        <span class="line"></span> 
        <span class="line"></span> 
        <span class="line" style="margin-bottom: 0;"></span>
    </button>
    <div class="collapse navbar-collapse" id="mobile-navbar-toggler">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" title="Home" href="index.php">
                    <i class="material-icons d-inline-block align-middle" style="font-size:2em;">home</i>
                </a>
            </li>
            </li>
            <li class="nav-item">
                <a class="nav-link" title="Movie" href="movie_template.php">
                    <i class="material-icons d-inline-block align-middle" style="font-size:2em;">movie</i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" title="About Us" href="about_us.php">About Us</a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
<!--    <li class="nav-item">
                <a class="nav-link" title="Sign In" href="profile_page.php">
                    <i class="material-icons d-inline-block align-middle">account_circle</i>
                </a>
            </li>-->
<form class="form-inline" action="search_results.php" method="post">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="material-icons d-inline-block align-middle">search</i>
                        </span>
                    </div>
                    <input required type="text" id="search_input" name="search_input" maxlength="40" class="form-control" placeholder="Search for movie title" aria-label="Search" aria-describedby="basic-addon1">
                </div>
            </form>

            <li class="nav-item">
                <a class="nav-link" title="Login" href="login.php">
                    <i class="material-icons" style="font-size:2em;">account_circle</i>
                </a>
            </li>
        </ul>
    </div>
</nav>