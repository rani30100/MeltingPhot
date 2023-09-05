document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.querySelector('#user_password');
    const showPasswordCheckbox = document.querySelector('#show_password_checkbox');
  
    showPasswordCheckbox.addEventListener('change', function() {
      if (this.checked) {
        passwordInput.type = 'text';
      } else {
        passwordInput.type = 'password';
      }
    });
  });
  