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
        
        if(interativeForm[index].classList.contains('open')) {
            interativeForm[index].classList.remove('open');
            interativeForm[index].classList.add('close');
        }
        else {
            interativeForm[index].classList.add('open');
            interativeForm[index].classList.remove('close');

            const follow_op = window.document.querySelectorAll('.right .interative-form.open #follow');
            const block_op = window.document.querySelectorAll('.right .interative-form.open #block');
            const delete_post = window.document.querySelectorAll('.right .interative-form.open #delete');
            var post_id = post_ids[index].id.replace(/\D/g,'');

            let xhr = new XMLHttpRequest();
            
            follow_op.forEach((btn, index) => {
                btn.addEventListener('click', () => {
                    xhr.open('POST', '../../app/php/posts/followLogic.php');
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                    if (follow_op[index].classList.contains('Follow')){
                        xhr.send('followbypost='+post_id);
                        
                    } else if (follow_op[index].classList.contains('Unfollow')) {
                        xhr.send('unfollowbypost='+post_id);
                    }
                    if (xhr.responseText = '1') {
                        follow_op[index].classList.add('Unfollow');
                        follow_op[index].classList.remove('Follow');
                        follow_op[index].innerHTML = 'Unfollow';
                    } else {
                        follow_op[index].classList.add('Follow');
                        follow_op[index].classList.remove('Unfollow');
                        follow_op[index].innerHTML = 'Follow';
                    }
                });
            });

            block_op.forEach((btn, index) => {
                btn.addEventListener('click', () => {
                    console.log('Follow'+post_id);
                    xhr.open('POST', '../../app/php/posts/manageBlock.php');
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.send('blockbypost='+post_id);

                    if (window.location.href.slice(-8) == 'home.php') {
                        post_ids[index].classList.add('animate');
                        const interval = setTimeout(()=>{
                            post_ids[index].remove(); 
                        },400);
                    } else
                        document.location.reload();
                });
            });

            delete_post.forEach((btn, index) => {
                btn.addEventListener('click', () => {
                    console.log('Follow'+post_id);
                    xhr.open('POST', '../../app/php/posts/deletePost.php');
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.send('deletePost='+post_id);

                    if (xhr.responseText = 'Deleted') {
                        post_ids[index].classList.add('animate');
                        const interval = setTimeout(()=>{
                            post_ids[index].remove(); 
                        },400);
                    }
                });
            });
        }
    });
});



likebtn.forEach((btn, index) => {
    btn.addEventListener('click', () => {

        var span = window.document.querySelectorAll('#feed .post .bottom-post .list #tab-like span');
        var post_id = post_ids[index].id.replace(/\D/g,'')

        let xhr = new XMLHttpRequest();

        xhr.open('POST', '../../app/php/posts/likeLogic.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        if (span[index].classList.contains('my-like')) {

            xhr.send('unlike=' + post_id);

            if (xhr.responseText = '0' ) {
            span[index].innerHTML = parseInt(span[index].innerHTML.replace(/\D/g,'')) - 1 + ' Likes';
            span[index].classList.remove('my-like')
            }
        } else {  
            
            xhr.send('like=' + post_id);

            if (xhr.responseText = '1' ) {
                span[index].innerHTML = parseInt(span[index].innerHTML.replace(/\D/g,'')) + 1 + ' Likes';
                span[index].classList.add('my-like')
            }
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
