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
        <!-- Custom JS -->
        <script defer src="js/main.js"></script>
    </head>
    <body>    
        <?php
            include "nav.inc.php";
        ?>
        <header class="jumbotron text-center">
            <h1 class="display-4">Welcome to World of Pets!</h1>
            <h2>Home of Singapore's Pet Lovers</h2>
        </header>
        <main class="container">
            <section id="dogs">
                <h1>All About Dogs!</h1>
                <div class="row">
                    <article class="col-sm">
                        <h2>Poodle</h2>
                        <figure>
                            <img class="img-thumbnail" src="images/poodle_small.jpg" alt="Poodle"
                                title="View larger image..."/>
                            <figcaption>Standard Poodle</figcaption>
                        </figure>
                        <p>
                            Poodles are a group of formal dog breeds, the 
                            Standard Poodle, Miniature Poodle and Toy Poodle.
                        </p>
                    </article>
                    <article class="col-sm">
                        <h2>Chihuahua</h2>
                        <figure>
                            <img class="img-thumbnail" src="images/chihuahua_small.jpg" alt="Chihuahua"
                                title="View larger image..."/>
                            <figcaption>Chihuahua</figcaption>
                        </figure>
                        <p>
                            The Chihuahua is the smallest breed of dog, and is 
                            named after the Mexican state of Chihuahua.
                        </p>
                    </article>
                </div>
            </section>
            <section id="cats">
                <h1>All About Cats!</h1>
                <div class="row">
                    <article class="col-sm">
                        <h2>Tabby</h2>
                        <figure>
                            <img class="img-thumbnail" src="images/tabby_small.jpg" alt="Tabby"
                                title="View larger image..."/>
                            <figcaption>Standard Tabby</figcaption>
                        </figure>
                        <p>
                            A tabby is any domestic cat (Felis catus) with a 
                            distinctive 'M' shaped marking on their forehead, 
                            stripes by their eyes and across their cheeks, along 
                            their back, and around their legs and tail.
                        </p>
                    </article>
                    <article class="col-sm">
                        <h2>Calico</h2>
                        <figure>
                            <img class="img-thumbnail" src="images/calico_small.jpg" alt="Calico"
                                title="View larger image..."/>
                            <figcaption>Standard Calico</figcaption>
                        </figure>
                        <p>
                            A calico cat is a domestic cat with a coat that is 
                            typically 25% to 75% white with large orange and 
                            black patches (or sometimes cream and grey patches). 
                        </p>
                    </article>
                </div>
            </section>
        </main>
        <?php
            include "footer.inc.php";
        ?>
    </body>
</html>