const tab_index = window.document.querySelectorAll('.tab-list .tab');
const underlines = window.document.querySelectorAll('.tab-list .tab div');
let lastUnderline = 0; 

tab_index.forEach((i, index) => {
    i.addEventListener('click', () => {
        underlines[lastUnderline].classList.remove('underline');

        underlines[index].classList.add('underline');
        lastUnderline = index; 
    });
});