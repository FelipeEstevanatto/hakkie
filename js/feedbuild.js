const tab_index = window.document.querySelectorAll('.tab-list .tab');
const underlines = window.document.querySelectorAll('.tab-list .tab div');

tab_index.forEach((i, index) => {
    i.addEventListener('click', () => {
        
        underlines[0].classList.remove('underline');
        underlines[1].classList.remove('underline');
        underlines[2].classList.remove('underline');

        underlines[index].classList.add('underline');

    });
});