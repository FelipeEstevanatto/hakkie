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

const menupost = window.document.querySelectorAll('#feed .post .top-post .right i.fas.fa-ellipsis-v');
const likebtn = window.document.querySelectorAll('#feed .post .bottom-post .list #tab-like');
const commentbtn = window.document.querySelectorAll('#feed .post .bottom-post .list #tab-comment');
const sharebtn = window.document.querySelectorAll('#feed .post .bottom-post .list #tab-share');
const post_ids = window.document.querySelectorAll('#feed .post');
const interativeForm = window.document.querySelectorAll('.interative-form');

menupost.forEach((btn, index) => {
    btn.addEventListener('click', () => {

        var post_id = post_ids[index].id.replace(/\D/g,'')

        // console.log('Open menu' + post_id);

        if(interativeForm[index].classList.contains('open')) {
            interativeForm[index].classList.remove('open');
            interativeForm[index].classList.add('close');
        }
        else {
            interativeForm[index].classList.add('open');
            interativeForm[index].classList.remove('close');
        }
    });
});

likebtn.forEach((btn, index) => {
    btn.addEventListener('click', () => {

        var span = window.document.querySelectorAll('#feed .post .bottom-post .list #tab-like span');
        var post_id = post_ids[index].id.replace(/\D/g,'')

        let xhr = new XMLHttpRequest();

        xhr.open('POST', '../../app/php/likeLogic.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        if (span[index].classList != 'my-like') {

            xhr.send('like=' + post_id);

            if (xhr.responseText = '1' ) {
                span[index].innerHTML = parseInt(span[index].innerHTML.replace(/\D/g,'')) + 1 + ' Likes';
                span[index].classList.add('my-like')
            }

            

            

        } else {  
            span[index].innerHTML = parseInt(span[index].innerHTML.replace(/\D/g,'')) - 1 + ' Likes';
            span[index].classList.remove('my-like')

            xhr.send('unlike=' + post_id);

        }

    });
});

commentbtn.forEach((btn, index) => {
    btn.addEventListener('click', () => {

        var post_id = post_ids[index].id.replace(/\D/g,'')

        window.location = document.location.href.slice(0, document.location.href.lastIndexOf('/')) + '/post.php?id='+post_id;

    });
});

sharebtn.forEach((btn, index) => {
    btn.addEventListener('click', () => {

        var post_id = post_ids[index].id.replace(/\D/g,'')

        var link = document.location.href.slice(0, document.location.href.lastIndexOf('/')) + '/post.php?id='+post_id;

        var dummy = document.createElement('input');
            document.body.appendChild(dummy);
            dummy.value = link;
            dummy.select();
            document.execCommand('copy');
            document.body.removeChild(dummy);
                
        window.document.querySelectorAll( '#'+post_ids[index].id + ' #tab-share span')[0].innerHTML = 'Link Copied!';
    });
});
