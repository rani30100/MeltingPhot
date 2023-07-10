	// Récupérer l'élément du bouton "previous"
	const prevButton = document.querySelector('.carousel-control-prev');

	// Récupérer l'élément du bouton "next"
	const nextButton = document.querySelector('.carousel-control-next');

	// Récupérer l'élément du carrousel
	const carouselInner = document.querySelector('.carousel-inner');

	// Ajouter un écouteur d'événement sur le clic du bouton "previous"
	prevButton.addEventListener('click', () => {
	// Supprimer la classe animate__fadeInRight du carrousel
	carouselInner.classList.remove('animate__fadeInRight');
	carouselInner.classList.add('animate__fadeInLeft');
	});

	// Ajouter un écouteur d'événement sur le clic du bouton "next"
	nextButton.addEventListener('click', () => {
	// Ajouter la classe animate__fadeInRight au carrousel
	carouselInner.classList.remove('animate__fadeInLeft');
	carouselInner.classList.add('animate__fadeInRight');
	});

