const buttonSetting = window.document.querySelectorAll('#container .settings .btn');
const formManage = window.document.querySelectorAll('#container .settings .form-manage');

buttonSetting.forEach((btn, index) => {
    btn.addEventListener('click', () => {
        if(formManage[index].classList.contains('close')) {
            formManage[index].classList.remove('close');
            formManage[index].classList.add('open');
            btn.classList.add('open');
        }
        else {
            formManage[index].classList.remove('open');
            formManage[index].classList.add('close');
            btn.classList.remove('open');
        }
    });
});

const unblockBtn = window.document.querySelectorAll('#container .settings #block-manage .block .right i');
const userBlocked = window.document.querySelectorAll('#container .settings #block-manage .block');

unblockBtn.forEach((i, index) => {
    i.addEventListener('click', () => {
        
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '../../app/php/manageBlock.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
 
        xhr.send('unblock='+unblockBtn[index].id.replace(/\D/g, ''));

        userBlocked[index].remove();
    });
});
