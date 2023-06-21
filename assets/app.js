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

//changer la locale 
document.addEventListener('DOMContentLoaded', function() {
    var flagImageFr = document.getElementById("flag-imagefr");
    var flagImageUk = document.getElementById("flag-imageuk");
    var locale = "{{ app.request.attributes.get('_locale') }}";
    
    if (locale === 'fr') {
        flagImageUk.style.display = "none";
    } else if (locale === 'en') {
        flagImageFr.style.display = "none";
    }
    });

    //barre de recherche
            const searchIcon = document.querySelector('#search-icon');
    const searchForm = document.querySelector('#search-form');

    searchIcon.addEventListener('click', () => {
    searchForm.classList.toggle('d-none');
    searchIcon.classList.toggle('d-none')
    });

     // Faire tourner le carrousel 
    document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('carouselIndicators');
    const carouselInstance = new bootstrap.Carousel(carousel);

    const nextButton = document.querySelector('.carousel-control-next');
    nextButton.addEventListener('click', function() {
        carouselInstance.next();
    });

    const prevButton = document.querySelector('.carousel-control-prev');
    prevButton.addEventListener('click', function() {
        carouselInstance.prev();
    });
    });
     // Faire tourner le carrousel mobile
    document.addEventListener('DOMContentLoaded', function() {
        const carouselMobile = document.getElementById('carouselIndicatorsMobile');
        const carouselInstanceMobile = new bootstrap.Carousel(carouselMobile);

        const nextButtonMobile = document.querySelector('#carouselIndicatorsMobile .carousel-control-next');
        nextButtonMobile.addEventListener('click', function() {
        carouselInstanceMobile.next();
        });

        const prevButtonMobile = document.querySelector('#carouselIndicatorsMobile .carousel-control-prev');
        prevButtonMobile.addEventListener('click', function() {
        carouselInstanceMobile.prev();
        });
    });

        //google analytique
        window.dataLayer = window.dataLayer || [];zzz
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-TB0K54FEJ4');
