const showPasswordBtn = window.document.querySelector('#show-password-btn');
const passwordInput = window.document.querySelector('#password');

showPasswordBtn.addEventListener('click', () => {

    if(showPasswordBtn.classList.contains('fa-eye-slash')) {
        showPasswordBtn.classList.remove('fa-eye-slash');
        showPasswordBtn.classList.add('fa-eye');

        passwordInput.type = 'text';
    }
    else {
        showPasswordBtn.classList.remove('fa-eye');
        showPasswordBtn.classList.add('fa-eye-slash');

        passwordInput.type = 'password';
    }
});
