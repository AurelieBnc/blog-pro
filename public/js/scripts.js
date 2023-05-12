/*!
* Start Bootstrap - Full Width Pics v5.0.5 (https://startbootstrap.com/template/full-width-pics)
* Copyright 2013-2022 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-full-width-pics/blob/master/LICENSE)
*/
// This file is intentionally blank
// Use this file to add JavaScript to your project

// Attente chargement complet du DOM
window.addEventListener("DOMContentLoaded", function() {
    console.log("DOM entièrement chargé");


///SYSTEME DE TABULATION///
    // Mise en place d'un écouteur d'évènement "click" sur tous les boutons du système de tabulation
    $('.tab-container .tabs .tab').click(function(){

        // On retire la classe "active" de l'ancien bouton
        $('.tab-container .tabs .tab.active').removeClass('active');

        // On met la classe "active" sur le bouton cliqué
        $(this).addClass('active');

        // On retire la classe "active" de l'ancienne vue pour la masquer
        $('.tab-container .views .view.active').removeClass('active');

        // On met la classe "active" sur la vue qui doit affichée (la vue dont l'id correspond au dataset data-open du bouton cliqué)
        $('#' + $(this).data('open') ).addClass('active');


    // ///SYSTEME DE TABULATION JS KO///
    //     const tab = document.querySelector('.tab-container .tabs .tab');
    //     const tabActive = document.querySelector('.tab-container .tabs .tab.active');
    //     const viewActive = document.querySelector('.tab-container .views .view.active');

    // // Mise en place d'un écouteur d'évènement "click" sur tous les boutons du système de tabulation
    // tab.addEventListener('click', function(){
    //     const dataView = '#' + this.dataset.open;
    //     console.log("data", dataView);

    //     // On retire la classe "active" de l'ancienne tab
    //     tabActive.classList.remove('active');

    //     // On met la classe "active" sur le bouton cliqué
    //     this.classList.add('active');

    //     // On retire la classe "active" de l'ancienne vue pour la masquer
    //     viewActive.classList.remove('active');

    //     // On met la classe "active" sur la vue qui doit être affichée (la vue dont l'id correspond au dataset data-open du bouton cliqué)
    //     const viewOpen = document.querySelector(dataView);
    //     console.log("viewOpen", viewOpen);
    //     viewOpen.classList.add('active');

});

  });

