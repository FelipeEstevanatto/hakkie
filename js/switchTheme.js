const switchThemeBtn = window.document.querySelector('#switch-theme-btn');
const inputTheme = window.document.querySelector('#theme-check');
const stateTheme = window.document.querySelector('#theme-state');
const body = window.document.querySelector('body');

switchThemeBtn.addEventListener('click', () => { 

    let xhr = new XMLHttpRequest();
    xhr.open('POST', '../../app/php/setTheme.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    if(inputTheme.checked) {
        body.classList.remove('light');
        body.classList.add('dark');

        stateTheme.innerHTML = 'DarkMode: <span>ON</span>';

        xhr.send('theme=dark');
    }
    else {
        body.classList.remove('dark');
        body.classList.add('light');

        stateTheme.innerHTML = 'DarkMode: <span>OFF</span>';

        xhr.send('theme=light');
    }
}); 
