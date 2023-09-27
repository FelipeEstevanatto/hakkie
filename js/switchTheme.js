const inputTheme = window.document.querySelector('#theme-check');
const stateTheme = window.document.querySelector('#theme-state');
const body = window.document.querySelector('body');

inputTheme.addEventListener('click', (value) => { 
    console.log('dark', value.target.checked)

    body.classList.toggle('white-mode');
}); 
