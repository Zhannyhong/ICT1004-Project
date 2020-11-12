<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <a class="navbar-brand" href="#">
        <img src="images/pets.svg" alt="LOGO"/>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mobile-navbar-toggler" aria-controls="mobile-navbar-toggler" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mobile-navbar-toggler">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" title="Home" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" title="Dogs" href="index.php#dogs">Dogs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" title="Cats" href="index.php#cats">Cats</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" title="Create Account" href="register.php">Register</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" title="Sign In" href="login.php">Sign In</a>
            </li>
        </ul>
    </div>
</nav>