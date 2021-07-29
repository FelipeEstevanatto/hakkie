const interactBtn = window.document.querySelector('#interact-btn');

interactBtn.addEventListener('click', () => {
    if(interactBtn.classList.contains('follow')) {
        interactBtn.classList.remove('follow');
        interactBtn.classList.add('unfollow');
        interactBtn.innerHTML = '<i class="fas fa-user-times"></i> <span>Unfollow</span>';

        let xhr = new XMLHttpRequest();
        xhr.open('POST', '../../app/php/followLogic.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.send('follow='+window.location.href.replace(/\D/g, ''));

    }
    else {
        interactBtn.classList.remove('unfollow');
        interactBtn.classList.add('follow');
        interactBtn.innerHTML = '<i class="fas fa-user-plus"></i> <span>Follow</span>';

        let xhr = new XMLHttpRequest();
        xhr.open('POST', '../../app/php/followLogic.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.send('unfollow='+window.location.href.replace(/\D/g, ''));
    }
});