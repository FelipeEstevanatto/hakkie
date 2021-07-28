const btn = window.document.querySelector('#ellipsis');
const modal = window.document.querySelector('#ellipsis-modal');

btn.addEventListener('click', () => {
    if(modal.classList.contains('open')) {
        modal.classList.remove('open');
        modal.classList.add('close');

        btn.innerHTML = '<i class="fas fa-ellipsis-v"></i>';
        
    }
    else {
        modal.classList.add('open');
        modal.classList.remove('close');

        btn.innerHTML = '<i class="fas fa-times"></i>';
    }
});