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

function onSignIn(googleUser) {
    var id_token = googleUser.getAuthResponse().id_token;

    sendToBack(id_token)
}

function sendToBack(id_token) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'app/google/verifyIntegrity.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.send('idtoken=' + id_token);

    window.location.href = 'http://localhost/google_login/home.php'
}

function onFailure(error) {
    console.log(error); 
}