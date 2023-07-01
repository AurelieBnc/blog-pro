/*!
* Start Bootstrap - Full Width Pics v5.0.5 (https://startbootstrap.com/template/full-width-pics)
* Copyright 2013-2022 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-full-width-pics/blob/master/LICENSE)
*/
// This file is intentionally blank
// Use this file to add JavaScript to your project

// Waiting for DOM full load
window.addEventListener("DOMContentLoaded", function() {
    console.log("DOM entièrement chargé");


    /// TAB SYSTEM ///
    // Implementation of a "click" event listener on all tab system buttons
    $('.tab-container .tabs .tab').click(function(){

        // We remove the "active" class from the old button
        $('.tab-container .tabs .tab.active').removeClass('active');

        // We put the "active" class on the clicked button
        $(this).addClass('active');

        // We remove the "active" class from the old view to hide it
        $('.tab-container .views .view.active').removeClass('active');

        // We put the "active" class on the view that must be displayed (the view whose id corresponds to the data-open dataset of the button clicked)
        $('#' + $(this).data('open') ).addClass('active');

    });

});

