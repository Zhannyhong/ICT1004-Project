<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="container">
    <!-----Slider----->
    <div id="slide">
        <div id="homeSlider" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#homeSlider" data-slide-to="0" class="active"></li>
                <li data-target="#homeSlider" data-slide-to="1"></li>
                <li data-target="#homeSlider" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="images/coming-soon-slider.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="images/coming-soon-slider.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="images/movies/avengers-endgame-poster-square-crop.jpg" class="d-block w-100" alt="...">
                </div>
            </div>
            <a class="carousel-control-prev" href="#homeSlider" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#homeSlider" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <!-----Top Rated Movies----->
    <div id="topRatedSec" class="container text-center my-3">
        <h2 class="font-weight-light ml-auto style-line">Top Rated movies</h2>
        <div class="row mx-auto my-auto">
            <div id="topRated" class="carousel slide carousel-multi-item" data-ride="carousel">



                <!--Indicators-->
                <ol class="carousel-indicators">
                    <li data-target="#topRated" data-slide-to="0" class="active"></li>
                    <li data-target="#topRated" data-slide-to="1"></li>
                    <li data-target="#topRated" data-slide-to="2"></li>
                </ol>
                <!--/.Indicators-->

                <!--Slides-->
                <div class="carousel-inner" role="listbox">



                    <!--First slide-->
                    <div class="carousel-item active">

                        <div class="row">

                            <div class="col-md-3">
                                <div class="card mb-2">
                                    <a href="movie_template.php/id?1">
                                    <img class="card-img" src="images/movies/SI.jpg"
                                         alt="Card image cap">
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-3 d-none d-md-block">
                                <div class="card mb-2">
                                    <img class="card-img-top" src="images/movies/SI.jpg"
                                         alt="Card image cap">
                                </div>
                            </div>

                            <div class="col-md-3 d-none d-md-block">
                                <div class="card mb-2">
                                    <img class="card-img-top" src="images/movies/SI.jpg"
                                         alt="Card image cap">
                                </div>
                            </div>

                            <div class="col-md-3 d-none d-md-block">
                                <div class="card mb-2">
                                    <img class="card-img-top" src="images/movies/SI.jpg"
                                         alt="Card image cap">
                                </div>
                            </div>
                        </div>

                    </div>
                    <!--/.First slide-->

                    <!--Second slide-->
                    <div class="carousel-item">

                        <div class="row">

                            <div class="col-md-3">
                                <div class="card mb-2">
                                    <img class="card-img-top" src="images/movies/MT.jpg"
                                         alt="Card image cap">
                                </div>
                            </div>

                            <div class="col-md-3 d-none d-md-block">
                                <div class="card mb-2">
                                    <img class="card-img-top" src="images/movies/MT.jpg"
                                         alt="Card image cap">
                                </div>
                            </div>

                            <div class="col-md-3 d-none d-md-block">
                                <div class="card mb-2">
                                    <img class="card-img-top" src="images/movies/MT.jpg"
                                         alt="Card image cap">
                                </div>
                            </div>

                            <div class="col-md-3 d-none d-md-block">
                                <div class="card mb-2">
                                    <img class="card-img-top" src="images/movies/MT.jpg"
                                         alt="Card image cap">
                                </div>
                            </div>

                        </div>

                    </div>
                    <!--/.Second slide-->

                    <!--Third slide-->
                    <div class="carousel-item">

                        <div class="row">

                            <div class="col-md-3">
                                <div class="card mb-2">
                                    <img class="card-img-top" src="images/movies/HA.jpg"
                                         alt="Card image cap">
                                </div>
                            </div>

                            <div class="col-md-3 d-none d-md-block">
                                <div class="card mb-2">
                                    <img class="card-img-top" src="images/movies/HA.jpg"
                                         alt="Card image cap">
                                </div>
                            </div>

                            <div class="col-md-3 d-none d-md-block">
                                <div class="card mb-2">
                                    <img class="card-img-top" src="images/movies/HA.jpg"
                                         alt="Card image cap">
                                </div>
                            </div>

                            <div class="col-md-3 d-none d-md-block">
                                <div class="card mb-2">
                                    <img class="card-img-top" src="images/movies/HA.jpg"
                                         alt="Card image cap">
                                </div>
                            </div>

                        </div>

                    </div>
                    <!--/.Third slide-->

                </div>
                <!--/.Slides-->
                <a class="carousel-control-prev w-auto" href="#topRated" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next w-auto" href="#topRated" role="button" data-slide="next">
                    <span class="carousel-control-next-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>

    <!-----Latest Movies----->       
    <div id="latestSec" class="container text-center my-3">
        <h2 class="font-weight-light ml-auto style-line">Latest movies</h2>
        <div class="row mx-auto my-auto">
            <div id="latestMovie" class="carousel slide carousel-multi-item" data-ride="carousel">

                <!--Indicators-->
                <ol class="carousel-indicators">
                    <li data-target="#latestMovie" data-slide-to="0" class="active"></li>
                    <li data-target="#latestMovie" data-slide-to="1"></li>
                    <li data-target="#latestMovie" data-slide-to="2"></li>
                </ol>
                <!--/.Indicators-->

                <!--Slides-->
                <div class="carousel-inner" role="listbox">

                    <!--First slide-->
                    <div class="carousel-item active">

                        <div class="row">

                            <div class="col-md-3">
                                <div class="card mb-2">
                                    <img class="card-img" src="images/movies/SI.jpg"
                                         alt="Card image cap">
                                </div>
                            </div>

                            <div class="col-md-3 d-none d-md-block">
                                <div class="card mb-2">
                                    <img class="card-img-top" src="images/movies/SI.jpg"
                                         alt="Card image cap">
                                </div>
                            </div>

                            <div class="col-md-3 d-none d-md-block">
                                <div class="card mb-2">
                                    <img class="card-img-top" src="images/movies/SI.jpg"
                                         alt="Card image cap">
                                </div>
                            </div>

                            <div class="col-md-3 d-none d-md-block">
                                <div class="card mb-2">
                                    <img class="card-img-top" src="images/movies/SI.jpg"
                                         alt="Card image cap">
                                </div>
                            </div>
                        </div>

                    </div>
                    <!--/.First slide-->

                    <!--Second slide-->
                    <div class="carousel-item">

                        <div class="row">

                            <div class="col-md-3">
                                <div class="card mb-2">
                                    <img class="card-img-top" src="images/movies/MT.jpg"
                                         alt="Card image cap">
                                </div>
                            </div>

                            <div class="col-md-3 d-none d-md-block">
                                <div class="card mb-2">
                                    <img class="card-img-top" src="images/movies/MT.jpg"
                                         alt="Card image cap">
                                </div>
                            </div>

                            <div class="col-md-3 d-none d-md-block">
                                <div class="card mb-2">
                                    <img class="card-img-top" src="images/movies/MT.jpg"
                                         alt="Card image cap">
                                </div>
                            </div>

                            <div class="col-md-3 d-none d-md-block">
                                <div class="card mb-2">
                                    <img class="card-img-top" src="images/movies/MT.jpg"
                                         alt="Card image cap">
                                </div>
                            </div>

                        </div>

                    </div>
                    <!--/.Second slide-->

                    <!--Third slide-->
                    <div class="carousel-item">

                        <div class="row">

                            <div class="col-md-3">
                                <div class="card mb-2">
                                    <img class="card-img-top" src="images/movies/HA.jpg"
                                         alt="Card image cap">
                                </div>
                            </div>

                            <div class="col-md-3 d-none d-md-block">
                                <div class="card mb-2">
                                    <img class="card-img-top" src="images/movies/HA.jpg"
                                         alt="Card image cap">
                                </div>
                            </div>

                            <div class="col-md-3 d-none d-md-block">
                                <div class="card mb-2">
                                    <img class="card-img-top" src="images/movies/HA.jpg"
                                         alt="Card image cap">
                                </div>
                            </div>

                            <div class="col-md-3 d-none d-md-block">
                                <div class="card mb-2">
                                    <img class="card-img-top" src="images/movies/HA.jpg"
                                         alt="Card image cap">
                                </div>
                            </div>

                        </div>

                    </div>
                    <!--/.Third slide-->

                </div>
                <!--/.Slides-->
                <a class="carousel-control-prev w-auto" href="#latestMovie" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next w-auto" href="#latestMovie" role="button" data-slide="next">
                    <span class="carousel-control-next-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
</div>
