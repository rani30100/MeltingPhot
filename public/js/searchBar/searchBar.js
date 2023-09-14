const searchIcon = document.getElementById("search-icon");
const searchForm = document.getElementById("search-form");
const searchButton = document.getElementById("search-button");


searchIcon.addEventListener("click", function () {
    // Affiche ou masque le formulaire de recherche lors du clic sur l'icône de recherche
    searchForm.classList.toggle("d-none");
});

searchButton.addEventListener("click", function (event) {
    // event.preventDefault(); // Empêche la soumission du formulaire

    // Récupère le terme de recherche saisi par l'utilisateur
    const searchTerm = document.getElementById("search-input").value.trim();
    if(searchTerm === null){

        // Vous pouvez ajouter votre propre logique de recherche ici, par exemple, une redirection vers une page de résultats
        window.location.href = "/search?q=" + encodeURIComponent(searchTerm);
    }else{
        window.location.href = "/search?q=" + encodeURIComponent(searchTerm);
        
        console.log("Terme de recherche : " + searchTerm);
    }


    // Pour le moment, nous affichons simplement le terme de recherche dans la console
});
