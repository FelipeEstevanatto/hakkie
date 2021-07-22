const switchThemeBtn = window.document.querySelector('#switch-theme-btn');
const body = window.document.querySelector('body');

switchThemeBtn.addEventListener('click', () => { 

    if(body.classList.contains('light')) {
        body.classList.remove('light');
        body.classList.add('dark');
    }
    else {
        body.classList.remove('dark');
        body.classList.add('light');
    }

}); 
