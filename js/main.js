/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// Consts
const ID_POPUP = "id_popup";

document.addEventListener('DOMContentLoaded', function(){
    register_event_handlers();
});

// Standard JS
function register_event_handlers() {
    // Register event handlers for the thumbnail popup images
    var thumbnails = document.getElementsByClassName("img-thumbnail");
    if (thumbnails !== null) {
        for (let i = 0; i < thumbnails.length; i++) {
            var thumbnail = thumbnails[i];
            thumbnail.addEventListener('click', togglePopup);
        }
    } else {
        console.log("No thumbnail images found!");
    }
} 

// Handles toggling of popup image.
function togglePopup(elem) {
    
    var popup = document.getElementById(ID_POPUP);
    
    // Is popup already showing?
    if (popup === null) {
        // No, so create it
        popup = document.createElement("span");
        popup.id = ID_POPUP;
        popup.setAttribute("class", "img-popup");
        
        // Derive the name of the big image from the small one
        var thumbnail = elem.target;
        var small_img = thumbnail.src;
        var big_img = small_img.replace("_small", "_large");
        
        popup.innerHTML = "<img src=" + big_img + ">";
        thumbnail.insertAdjacentElement("afterend", popup);
    } else {
        popup.remove();
    }
}