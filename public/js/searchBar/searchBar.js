// All NavSearchBar ---------------------------------------------------------------------------------------------------------------

const searchIcon = document.getElementById("search-icon");
const searchForm = document.getElementById("search-form");

searchIcon.addEventListener("click", function () {
    // Affiche ou masque le formulaire de recherche lors du clic sur l'icône de recherche
    searchForm.classList.toggle("d-none");
    searchIcon.classList.add("d-none");
});

searchForm.addEventListener("submit", function (event) {
    event.preventDefault(); // Empêche la soumission du formulaire

    // Récupère le terme de recherche saisi par l'utilisateur
    const searchTerm = document.getElementById("search-input").value.trim();

    // Redirige l'utilisateur vers la page de résultats de recherche avec le terme de recherche comme paramètre dans l'URL
    window.location.href = "/search?q=" + encodeURIComponent(searchTerm);
});
// ---------------------------------------------------------------------------------------------------------------------------------