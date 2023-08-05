// Attendez que le document soit entièrement chargé et prêt à être manipulé
document.addEventListener('DOMContentLoaded', function() {
    // Sélectionnez tous les éléments avec la classe "lazy-video" et stockez-les dans la variable "lazyVideos"
    const lazyVideos = document.querySelectorAll('.lazy-video');

    // Créez une instance de l'observateur d'intersection
    const observer = new IntersectionObserver((entries, observer) => {
        // Parcourez toutes les entrées d'intersection détectées
        entries.forEach(entry => {
            // Vérifiez si l'élément est actuellement en intersection avec la fenêtre visible
            if (entry.isIntersecting) {
                // Récupérez l'élément vidéo cible à partir de l'entrée
                const video = entry.target;
                // Récupérez l'URL de la vidéo à partir de l'attribut "data-src" de l'élément vidéo
                const src = video.getAttribute('data-src');

                // Modifiez l'attribut "src" de l'élément vidéo avec l'URL récupérée
                video.src = src;

                // Cessez d'observer cet élément vidéo une fois qu'il a été chargé
                observer.unobserve(video);
            }
        });
    });

    // Parcourez tous les éléments vidéo avec la classe "lazy-video" et observez-les
    lazyVideos.forEach(video => {
        observer.observe(video);
    });
});
