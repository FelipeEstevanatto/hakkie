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
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../../app/google/verifyIntegrity.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.send('id_token=' + id_token);
    console.log("Here");
    console.log(xhr.responseText);
    window.location.href = 'http://localhost/hakkie/public/views/home.php'
}

function onSignIn(googleUser) {
    var id_token = googleUser.getAuthResponse().id_token;

    sendToBack(id_token)
}

function onFailure(error) {
    console.log(error);
}