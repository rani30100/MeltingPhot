/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';

const $ = require('jquery');

// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

// $(document).ready(function() {
//     $('[data-toggle="popover"]').popover();
// });

// All NavSearchBar ---------------------------------------------------------------------------------------------------------------

const searchIcon = document.getElementsByClassName("search-icon");
const searchForm = document.getElementsByClassName("search-form");

searchIcon.addEventListener("click", function () {
    // Affiche ou masque le formulaire de recherche lors du clic sur l'icône de recherche
    searchForm.classList.toggle("d-none");
    console.log('heyeef')
});

searchForm.addEventListener("submit", function (event) {
    event.preventDefault(); // Empêche la soumission du formulaire

    // Récupère le terme de recherche saisi par l'utilisateur
    const searchTerm = document.getElementById("search-input").value.trim();

    // Redirige l'utilisateur vers la page de résultats de recherche avec le terme de recherche comme paramètre dans l'URL
    window.location.href = "{{ path('app_search_results') }}?q=" + encodeURIComponent(searchTerm);
});
// ---------------------------------------------------------------------------------------------------------------------------------