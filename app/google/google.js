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
    if (document.location.pathname == "/hakkie/public/views/login.php") {
        var path = '../../app/google/verifyIntegrity.php';
    } else {
        var path = 'app/google/verifyIntegrity.php';
    }

    var xhr = new XMLHttpRequest();

    xhr.open('POST', path);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.send('id_token=' + id_token);

    xhr.onreadystatechange = () => {
        if(xhr.readyState == 4 && xhr.status == 200 && xhr.responseText == 'Sucess') {
            window.location.href = 'http://localhost/hakkie/public/views/home.php'
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