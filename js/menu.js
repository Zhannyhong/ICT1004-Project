/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 *  This function toggles the nav menu active/inactive status as
 * different pages are selected. It should be called from $(document).ready()
 * or whenever the page loads.
*/

/*
function activateMenu() {
    var current_page_URL = location.href;
    $(".navbar-nav a").each(function() {
        var target_URL = $(this).prop("href");
        if (target_URL === current_page_URL) {
            $('nav a').parents('li, ul').removeClass('active');
            $(this).parent('li').addClass('active');
            return false;
        };
    });
};
*/

function activateMenu() {
    var current_page_URL = location.href;
    var nav_links = document.querySelectorAll(".navbar-nav a");
    nav_links.forEach(function(element){
        target_URL = element.href;
        if (target_URL === current_page_URL) {
            element.parentElement.classList.add("active");
        } else {
            element.parentElement.classList.remove("active");
        }
    });
};

document.addEventListener('DOMContentLoaded', function(){
    activateMenu();
});