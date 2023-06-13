//page actions
const btn = document.querySelector('#bouton');

btn.addEventListener("click", [console.console.log('ca marche')]);

document.getElementById("my-dropdown2").addEventListener("change", function () {
var option = this.options[this.selectedIndex];
if (option.value == "option-3") {
window.location.href = "/actions/2022";
}
});

document.getElementById("my-dropdown2").addEventListener("change", function () {
var option = this.options[this.selectedIndex];
if (option.value == "option-2") {
window.location.href = "/actions/2023";
}
});


// Modal
const myModal = document.getElementById('myModal')
const myInput = document.getElementById('myInput')

myModal.addEventListener('shown.bs.modal', () => {
myInput.focus()
})


const videos = document.getElementById('video-container');
videos.style.display = 'none';

const link = document.getElementById('video-link');
link.addEventListener('click', (event) => {
event.preventDefault(); // Prevents navigation to the link

if (videos.style.display === 'none') {
videos.style.display = 'flex'; // Show the videos
} else {
videos.style.display = 'none'; // Hide the videos
}
});

// deleted video

// Sélectionnez tous les boutons avec la classe 'deleted-video'
const deletedVideos = document.querySelectorAll('.deleted-video');

// Parcourez chaque bouton et vérifiez le texte à l'intérieur
deletedVideos.forEach((button) => {
const buttonText = button.innerText.trim();

// Vérifiez si le texte est "Deleted video"
if (buttonText === 'Deleted video') { // Masquez le bouton en ajoutant la classe 'd-none'
button.classList.add('d-none');
}
});

//Faire tourner le carousel
document.addEventListener('DOMContentLoaded', function () {
    var carousel = document.getElementById('carouselExampleIndicators');
    var carouselInstance = new bootstrap.Carousel(carousel);

    var nextButton = document.querySelector('.carousel-control-next');
    nextButton.addEventListener('click', function () {
    carouselInstance.next();});
});