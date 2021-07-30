let input = window.document.querySelector('#uploadfile');
let preview = window.document.querySelector('#images-preview');

input.addEventListener('change', () => {
    preview.innerHTML = '';

    //console.log(input.files)

    for(let i = 0; i < input.files.length; i++) {
        if(i == 4) break;
        preview.innerHTML += '<img src="' + URL.createObjectURL(input.files[i]) + '">';
    }
});