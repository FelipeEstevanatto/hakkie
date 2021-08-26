const switchThemeBtn = window.document.querySelector('#switch-theme-btn');
const inputTheme = window.document.querySelector('#theme-check');
const stateTheme = window.document.querySelector('#theme-state');
const body = window.document.querySelector('body');

switchThemeBtn.addEventListener('click', () => { 

    if(inputTheme.checked) {

        document.cookie = "darkMode=dark"
        body.classList.remove('light');
        body.classList.add('dark');

        stateTheme.innerHTML = 'DarkMode: <span>ON</span>';
    }
    else {
        document.cookie = "darkMode=light"
        body.classList.remove('dark');
        body.classList.add('light');

        stateTheme.innerHTML = 'DarkMode: <span>OFF</span>';
    }
}); 
