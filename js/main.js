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
