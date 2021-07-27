const interactBtn = window.document.querySelector('#interact-btn');

interactBtn.addEventListener('click', () => {
    if(interactBtn.classList.contains('follow')) {
        interactBtn.classList.remove('follow');
        interactBtn.classList.add('unfollow');
        interactBtn.innerHTML = '<i class="fas fa-user-times"></i> Unfollow';

        let xhr = new XMLHttpRequest();
        xhr.open('GET', '../../app/php/followLogic.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.send();
    }
    else {
        interactBtn.classList.remove('unfollow');
        interactBtn.classList.add('follow');
        interactBtn.innerHTML = '<i class="fas fa-user-plus"></i> Follow';

        let xhr = new XMLHttpRequest();
        xhr.open('GET', '../../app/php/followLogic.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.send();
    }
});