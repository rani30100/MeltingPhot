// Récupérer les éléments des employés
const employee1 = document.getElementById('employee1');
const employee2 = document.getElementById('employee2');
const employee3 = document.getElementById('employee3');

// Récupérer les éléments des citations
const employeeQuote1 = document.getElementById('employeeQuote1');
const employeeQuote2 = document.getElementById('employeeQuote2');
const employeeQuote3 = document.getElementById('employeeQuote3');

// Fonction pour afficher ou masquer les citations en fonction de l'employé cliqué
function toggleQuotes(employee, employeeQuote) {
employee.addEventListener('click', () => {
    if (employeeQuote.style.display === 'none') {
    employeeQuote.style.display = 'block';
    } else {
    employeeQuote.style.display = 'none';
    }
});
}
// Appeler la fonction pour chaque employé
toggleQuotes(employee1, employeeQuote1);
toggleQuotes(employee2, employeeQuote2);
toggleQuotes(employee3, employeeQuote3);

// Fonction pour changer les informations
function changerInformations(employeId) {
// Récupérer les éléments du directeur
const directeurImage = document.getElementById('employeeImage');
const directeurNom = document.getElementById('employeeName');
const directeurJob = document.getElementById('employeeJob');
const directeurQuote = document.querySelector('.employeeQuote');
const directeurSocialMedia = document.getElementById('employeeSocialMedia1');

// Récupérer les éléments de l'employé cliqué
const employeImage = document.getElementById('employeeImage' + employeId);
const employeNom = document.getElementById('employeeName' + employeId);
const employeJob = document.getElementById('employeeJob' + employeId);
const employeQuote = document.querySelector('.employeeQuote' + employeId);
const employeSocialMedia = document.getElementById('employeeSocialMedia' + employeId);

// Sauvegarder les informations du directeur
const directeurImageSrc = directeurImage.src;
const directeurNomText = directeurNom.textContent;
const directeurJobText = directeurJob.textContent;
const directeurQuoteText = directeurQuote.innerHTML;
const directeurSocialMediaHTML = directeurSocialMedia.innerHTML;

// Changer les informations du directeur avec celles de l'employé
directeurImage.src = employeImage.src;
directeurNom.textContent = employeNom.textContent;
directeurJob.textContent = employeJob.textContent;
directeurQuote.innerHTML = employeQuote.innerHTML;
directeurSocialMedia.innerHTML = employeSocialMedia.innerHTML;

// Changer les informations de l'employé avec celles du directeur
employeImage.src = directeurImageSrc;
employeNom.textContent = directeurNomText;
employeJob.textContent = directeurJobText;
employeQuote.innerHTML = directeurQuoteText;
employeSocialMedia.innerHTML = directeurSocialMediaHTML;
}

// Ajouter des écouteurs d'événements sur les employés
let employe1 = document.getElementById('employee1');
employe1.addEventListener('click', function() {
changerInformations('1');
});

let employe2 = document.getElementById('employee2');
employe2.addEventListener('click', function() {
changerInformations('2');
});

let employe3 = document.getElementById('employee3');
employe3.addEventListener('click', function() {
changerInformations('3');
});

// Assigner les citations aux employés
const citationDirecteur = "La photographie est bien plus qu'une simple image figée, c'est une fenêtre ouverte sur le monde..";
const citationEmploye1 = "La photographie est une plume qui donne vie à nos histoires, capturant l'essence même de chaque instant.";
const citationEmploye2 = "La photographie est notre langage, notre moyen de capturer l'instant présent et de le transformer en un souvenir intemporel";
const citationEmploye3 = "La photographie est bien plus qu'une simple capture d'image, c'est un langage artistique à part entière.";

document.querySelector('.employeeQuote').innerText = citationDirecteur;
document.querySelector('.employeeQuote1').innerText = citationEmploye1;
document.querySelector('.employeeQuote2').innerText = citationEmploye2;
document.querySelector('.employeeQuote3').innerText = citationEmploye3;