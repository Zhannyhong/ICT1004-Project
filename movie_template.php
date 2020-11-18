<html lang="en">    
    <head>
        <?php
            include "head.inc.php";
        ?>
        <title>Individual Movie Review Template</title>
        <link rel="stylesheet" href="css/movie_template.css">
    </head>
    <body>
        <?php
        include "nav.inc.php";
        ?>
        <main class="container">
            <div class="row">
                <div class="col-sm-4">
                    <figure>
                        <img src="images/poodle_large.jpg" 
                             class="rounded" 
                             alt="Movie Poster">
                    </figure>
                </div>
                <div class="col">
                    <h1>Movie Title</h1>
                    <ul class="list-group list-group-horizontal-sm">
                        <a href="#" class="list-group-item list-group-item-action">1 November 2020</a>
                        <a href="#" class="list-group-item list-group-item-action">90min</a>
                        <a href="#" class="list-group-item list-group-item-action">Action</a>
                        <a href="#" class="list-group-item list-group-item-action">PG</a>
                        <a href="#" class="list-group-item list-group-item-action">4.8⭐</a>
                    </ul>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Duis eget euismod mauris. Cras vitae tincidunt massa, 
                        sed tincidunt enim. Quisque rhoncus porta libero quis 
                        vulputate. Fusce ac viverra ex, ac rutrum libero. 
                        Mauris ac ipsum dui. Maecenas quis mi vulputate, 
                        convallis massa vitae, vehicula tellus. Morbi sit amet 
                        nisl quis lectus commodo laoreet. Nam sagittis quis diam
                        at aliquam. Mauris elit leo, efficitur nec erat ac, 
                        feugiat ullamcorper diam. Donec molestie quam a arcu 
                        mollis placerat.
                    </p>
                    <h2>Cast and Crew</h2>
                    <div class="card-group">
                        <div class="card text-center">
                            <img src="images/tabby_small.jpg" class="card-img-top" alt="Director">
                            <div class="card-body">
                                <h5 class="card-title">Director</h5>
                                <p class="card-text">Name</p>
                            </div>
                        </div>
                        <div class="card text-center">
                            <img src="images/tabby_small.jpg" class="card-img-top" alt="Producer">
                            <div class="card-body">
                                <h5 class="card-title">Producer</h5>
                                <p class="card-text">Name</p>
                            </div>
                        </div>
                        <div class="card text-center">
                            <img src="images/tabby_small.jpg" class="card-img-top" alt="Actor">
                            <div class="card-body">
                                <h5 class="card-title">Actor 1</h5>
                                <p class="card-text">Name</p>
                            </div>
                        </div>
                        <div class="card text-center">
                            <img src="images/tabby_small.jpg" class="card-img-top" alt="Actor 2">
                            <div class="card-body">
                                <h5 class="card-title">Actor 2</h5>
                                <p class="card-text">Name</p>
                            </div>
                        </div>
                        <div class="card text-center">
                            <img src="images/tabby_small.jpg" class="card-img-top" alt="Actor 3">
                            <div class="card-body">
                                <h5 class="card-title">Actor 3</h5>
                                <p class="card-text">Name</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <h1>Reviews</h1>
                <ul class="list-unstyled">
                    <li class="media">
                        <img src="images/tabby_small.jpg" class="avatar mr-3" alt="Reviewer">
                        <div class="media-body">
                            <h5 class="mt-0 mb-1">5⭐: Good title</h5>
                            Cras sit amet nibh libero, in gravida nulla. Nulla vel
                            metus scelerisque ante sollicitudin. Cras purus odio, 
                            vestibulum in vulputate at, tempus viverra turpis.
                        </div>
                    </li>
                    <li class="media">
                        <img src="images/tabby_small.jpg" class="avatar mr-3" alt="Reviewer">
                        <div class="media-body">
                            <h5 class="mt-0 mb-1">5⭐: Good title</h5>
                            Cras sit amet nibh libero, in gravida nulla. Nulla vel
                            metus scelerisque ante sollicitudin. Cras purus odio, 
                            vestibulum in vulputate at, tempus viverra turpis.
                        </div>
                    </li>
                    <li class="media">
                        <img src="images/tabby_small.jpg" class="avatar mr-3" alt="Reviewer">
                        <div class="media-body">
                            <h5 class="mt-0 mb-1">4⭐: Decent but can be improved</h5>
                            Cras sit amet nibh libero, in gravida nulla. Nulla vel
                            metus scelerisque ante sollicitudin. Cras purus odio, 
                            vestibulum in vulputate at, tempus viverra turpis.
                        </div>
                    </li>
                </ul>
            </div>
        </main>
        
        <?php
        include "footer.inc.php";
        ?>
    </body>
</html>