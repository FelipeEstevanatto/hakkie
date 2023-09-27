const inputTheme = window.document.querySelector('#theme-check');
const stateTheme = window.document.querySelector('#theme-state');
const body = window.document.querySelector('body');

inputTheme.addEventListener('click', (value) => { 
    console.log('dark', value.target.checked)

    body.classList.toggle('dark');
    if (value.target.checked) {
        localStorage.setItem('theme', 'dark');
        stateTheme.innerHTML = 'Dark';
    } else {
        localStorage.setItem('theme', 'light');
        stateTheme.innerHTML = 'Light';
    }
}); 
