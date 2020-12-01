/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {
    $('#ToTopButton').click(function(event) {
        // prevent default anchor click behaviour
        event.preventDefault();
        $("html, body").animate({scrollTop: 0}, "slow");
        return false;
    });
});

$('.carousel').carousel({
    interval: 10000
});

/*-----Back to top button-----*/
// check if user scrolls too far down
$(window).scroll(function() {
    var height = $(window).scrollTop();
    if (height > 30) {
        $('#ToTopButton').fadeIn();
    }
    else {
        $('#ToTopButton').fadeOut();
    }
});

// Add active class to the current button (highlight it)
$(function() {
        // this will get the full URL at the address bar
        var url = window.location.href;
        // passes on every "a" tag
        $(".topnav a").each(function() {
            // checks if its the same on the address bar
            if (url === (this.href)) {
                $(this).closest("a").addClass("active");
                //for making parent of submenu active
               $(this).closest("a").parent().parent().addClass("active");
            }
        });
    });        

function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
        document.getElementById('login').innerHTML = "Login";
        document.getElementById('menu').innerHTML = "Menu";

  } else {
    x.className = "topnav";
  }
}

