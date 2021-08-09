function renderButton() {
    gapi.signin2.render('my-signin2', {
        'scope': 'profile email',
        'width': 270,
        'height': 60,
        'longtitle': true,
        'theme': 'dark',
        'onsuccess': onSignIn,
        'onfailure': onFailure
    });
}

function sendToBack(id_token) {

    var redirect = document.location.href;

    if (redirect.slice(-9) == 'login.php') {
        console.log('Login');
        var path = '../../app/google/verifyIntegrity.php';
        redirect = redirect.slice(0, redirect.lastIndexOf('login.php')) + 'home.php';
    } else {
        console.log('Index');
        var path = 'app/google/verifyIntegrity.php';
        redirect = redirect.slice(0, redirect.lastIndexOf('/')) + '/public/views/home.php';
    }

    var xhr = new XMLHttpRequest();

    xhr.open('POST', path);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.send('id_token=' + id_token);

    xhr.onreadystatechange = () => {
        console.log('StateChange');
        if(xhr.readyState == 4 && xhr.status == 200 && xhr.responseText == 'Sucess') {
            window.location.href = redirect;
        }
    };
    
}

function onSignIn(googleUser) {
    var id_token = googleUser.getAuthResponse().id_token;

    sendToBack(id_token)
}

function onFailure(error) {
    console.log(error);
}