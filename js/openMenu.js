const btn = window.document.querySelector('#ellipsis');
const modal = window.document.querySelector('#ellipsis-modal');

const blockUserBtn = window.document.querySelector('#ellipsis-modal .btn#block_user');
const silenceUserBtn = window.document.querySelector('#ellipsis-modal .btn#silence_user');
const linkUserBtn = window.document.querySelector('#ellipsis-modal .btn:last-child');

btn.addEventListener('click', () => {
    if(modal.classList.contains('open')) {
        modal.classList.remove('open');
        modal.classList.add('close');

        btn.innerHTML = '<i class="fas fa-ellipsis-v"></i>';
        linkUserBtn.innerHTML = 'Copy Profile Link';    
    }
    else {
        modal.classList.add('open');
        modal.classList.remove('close');

        btn.innerHTML = '<i class="fas fa-times"></i>';
    }
});

silenceUserBtn.addEventListener('click', () => {
    console.log("Silence");
});

blockUserBtn.addEventListener('click', () => {

    let xhr = new XMLHttpRequest();
    xhr.open('POST', '../../app/php/manageBlock.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.send('block='+window.location.href.replace(/\D/g, ''));

});

linkUserBtn.addEventListener('click', () => {
    var dummy = document.createElement('input'),
    text = window.location.href;
    document.body.appendChild(dummy);
        dummy.value = text;
        dummy.select();
        document.execCommand('copy');
        document.body.removeChild(dummy);
        
    linkUserBtn.innerHTML = 'Link Copied!';

});
