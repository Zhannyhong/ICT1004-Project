/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var stars = document.querySelectorAll(".rating span");;
var rating = document.getElementById("rating");
rating.value = "";

function setRating(clickedStar) {
    var previousStar = document.querySelector(".rating span.is-active");
    if (previousStar !== null) {
        previousStar.classList.remove("is-active");
    }
    clickedStar.classList.add("is-active");
    var starSelected = document.querySelector(".rating span.is-active");
    rating.value = starSelected.getAttribute("data-score");
    showRating(rating.value);
}

function showRating(score) {
    for (let i = 0; i < 5; i++) {
        if (i < score) {
            stars[i].classList.add("is-highlighted");
        } else {
            stars[i].classList.remove("is-highlighted");
        }
    }
}

stars.forEach(star => {
    star.addEventListener('click', function() {
        setRating(this);
    });
});