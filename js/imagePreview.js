let input = window.document.querySelector('#uploadfile');
let preview = window.document.querySelector('#images-preview');

input.addEventListener('change', () => {
    preview.innerHTML = '';

    for(let i = 0; i < input.files.length; i++) {
        if(i == 4) break;
        if(input.files[i].name.split('.')[1] == 'mp4') {
            preview.innerHTML += '<video controlsList="nodownload" style="border-radius: 5%;"><source src="'+ URL.createObjectURL(input.files[i]) +'" type="video/mp4"></video>';
            preview.innerHTML += '<span style="position: relative; left: 10%;">'+input.files[i].name+'<span>';
        } else {
            preview.innerHTML += '<img src="' + URL.createObjectURL(input.files[i]) + '">';
        }
    }
});