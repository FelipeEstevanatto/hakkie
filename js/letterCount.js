const textarea = window.document.querySelector('#textarea');
const count = window.document.querySelector('#count');

textarea.addEventListener('input', () => {
    count.innerHTML = 256 - textarea.value.length;
});

count.innerHTML = 256 - textarea.value.length;