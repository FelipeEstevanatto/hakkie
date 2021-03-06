let input = window.document.querySelector('#uploadfile');
let preview = window.document.querySelector('#images-preview');

input.addEventListener('change', () => {
    preview.innerHTML = '';
    var previewS = '';

    for(let i = 0; i < input.files.length; i++) {
        if(i == 4) break;
        input 

        previewS += '<div style="display:grid;">';

        if(input.files[i].name.split('.')[1] == 'mp4') {
            previewS += '<video controlsList="nodownload" style="border-radius: 5%;"><source src="'+ URL.createObjectURL(input.files[i]) +'" type="video/mp4"></video>';
        } else {
            previewS += '<img src="' + URL.createObjectURL(input.files[i]) + '">';
        }
        previewS += '<span style="position: absolute; left: 2%; text-shadow: 2px 2px 1px #000000;">'+input.files[i].name+'<i class="fas fa-times-circle" style=""></i><span></div>'; 
    }
    preview.innerHTML += previewS;
});