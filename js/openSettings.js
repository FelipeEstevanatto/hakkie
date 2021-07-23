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