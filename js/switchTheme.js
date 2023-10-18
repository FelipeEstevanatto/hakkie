const inputTheme = window.document.querySelector('#theme-check');
const stateTheme = window.document.querySelector('#theme-state');

inputTheme.addEventListener('click', (value) => { 
    fetch('edittheme', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'theme=' + value.target.checked
    }).then(response => {
        if (response.ok) {
            return response.json();
        } else {
            throw new Error('Network response was not ok');
    }
    }
    ).then(data => {
        if (data.theme) {
            localStorage.setItem('theme', 'dark');
            window.document.documentElement.classList.add('dark');
            stateTheme.innerHTML = 'ON';
        } else {
            localStorage.setItem('theme', '');
            window.document.documentElement.classList.remove('dark');
            stateTheme.innerHTML = 'OFF';
        }

    }).catch(error => {
        console.error(error);
    });
});