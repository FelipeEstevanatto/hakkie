const textInput = window.document.querySelector('#update-info');
const countOut = window.document.querySelector('#update-info-count');

textInput.addEventListener('input', () => {
    countOut.innerHTML = 256 - textInput.value.length;
});

countOut.innerHTML = 256 - textInput.value.length;