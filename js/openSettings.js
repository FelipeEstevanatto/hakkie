const buttonSetting = window.document.querySelectorAll('#container .settings div.btn');
const formManage = window.document.querySelectorAll('#container .settings .form-manage');
buttonSetting.forEach((btn) => {
    btn.addEventListener('click', () => {
        const form = window.document.querySelector(`#container .settings #${btn.id}-manage`);
        form.classList.toggle('hidden');
        btn.classList.toggle('rounded-b-lg');
        btn.classList.toggle('mb-6');
    });
});

const blockedBox = window.document.getElementById('block-manage');
window.document.addEventListener('click', (event) => {
    if (event.target.matches('#container .settings #block-manage .block .right i')) {
        //console.log('aa', blockedBox)
        const block = event.target.closest('.block');
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'blockingLogic');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.addEventListener('readystatechange', () => {
            if (xhr.readyState === 4 && xhr.responseText === 'Sucess unblocking') {
                block.remove();
                if (window.document.querySelectorAll('#container .settings #block-manage.open .block').length === 0) {
                    blockedBox.innerHTML = '<span><i class="fas fa-thumbs-up"></i> You have no blocks, nice!</span>';
                }
            }
        });
        xhr.send(`unblock=${block.id}`);
    }
});