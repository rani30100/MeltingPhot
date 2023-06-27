  document.addEventListener("DOMContentLoaded", function() {
    let navbarContent = document.getElementById('navbarToggleExternalContent');
    let navbarToggler = document.querySelector('.navbar-toggler');
    let isNavbarVisible = false;

    navbarToggler.addEventListener('click', function() {
      if (!isNavbarVisible) {
        navbarContent.classList.add('show');
        isNavbarVisible = true;
      } else {
        navbarContent.classList.remove('show');
        isNavbarVisible = false;
      }
    });
  });
