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
const blockedBox = window.document.getElementById('block-manage');

unblockBtn.forEach((i, index) => {
    i.addEventListener('click', () => {
        
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'blockingLogic');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
 
        xhr.addEventListener("readystatechange", function () {
            if (this.readyState === 4 && xhr.responseText === 'Sucess unblocking') {
                userBlocked[index].remove();
                if (unblockBtn.length-1 == 0) {
                    blockedBox.innerHTML = '<span><i class="fas fa-thumbs-up"></i> You have no blocks, nice!</span>'
                }
            }
        });

        xhr.send('unblock='+window.document.querySelectorAll('#container .settings #block-manage.open .block')[index].id); 

    });
});
