document.addEventListener('DOMContentLoaded', function () {
    var videoButtons = document.querySelectorAll('.videos-btn');
    
    videoButtons.forEach(function (button) {
    button.addEventListener('click', function () {
    var videoId = button.dataset.videoId;
    var modalBody = button.closest('.modal').querySelector('.modal-body');
    
    var iframe = document.createElement('iframe');
    iframe.className = 'embed-responsive-item w-100 modal-video';
    iframe.src = 'https://www.youtube.com/embed/' + videoId + '?rel=0';
    iframe.allowfullscreen = true;
    iframe.allow = 'autoplay';
    
    modalBody.innerHTML = '';
    modalBody.appendChild(iframe);
    });
    });
    });