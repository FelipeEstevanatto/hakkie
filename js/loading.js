const button = window.document.querySelector('.container .right form input[type="submit"]');

if (button !== null) {
    button.addEventListener('click', () => {

        if (document.getElementById("email").value.length > 0 && document.getElementById("password").value.length > 0 &&
        /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.getElementById("email").value) ) {
            
            document.body.innerHTML += '<div id="loading-div"><img id="loading-gif" src="public/images/loading-buffering.gif" alt="loading-gif"></div>';
        }
    });
}