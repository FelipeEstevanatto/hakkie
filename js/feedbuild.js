const doc = window.document;

const tab_index = doc.querySelectorAll('.tab-list .tab');
const underlines = doc.querySelectorAll('.tab-list .tab div');
let lastUnderline = 0; 

tab_index.forEach((i, index) => {
    i.addEventListener('click', () => {
        underlines[lastUnderline].classList.remove('underline');

        underlines[index].classList.add('underline');
        lastUnderline = index; 
    });
});

const menupost = doc.querySelectorAll('#feed .post .top-post .right i.fas.fa-ellipsis-v');
const likebtn = doc.querySelectorAll('#feed .post .bottom-post .list #tab-like');
const commentbtn = doc.querySelectorAll('#feed .post .bottom-post .list #tab-comment');
const sharebtn = doc.querySelectorAll('#feed .post .bottom-post .list #tab-share');
const user_ids = doc.querySelectorAll('#feed .post .top-post .left');
const interativeForm = doc.querySelectorAll('.interative-form');
const posts = doc.querySelectorAll('#feed .post');

posts.forEach(post => {
    post.addEventListener('click', (event) => {
        const target = event.target;
        switch (true) {
            case post.querySelector('i.fas.fa-ellipsis-v').contains(target):
                console.log('menu')
                openMenu(post);
                break;
            case post.querySelector('#tab-like').contains(target):
                console.log('like')
                likePost(post);
                break;
            case post.querySelector('#tab-comment').contains(target):
                console.log('comment')
                commentPost(post);
                break;
            case post.querySelector('#tab-share').contains(target):
                console.log('share')
                shareLink(post);
                break;
            case post.querySelector('#delete').contains(target):
                console.log('form')
                deletePost(post);
                break;
        }
        console.log(target, post.id)
    });
});

function openMenu(post) {
    const form = post.querySelector('.interative-form');
    if (form !== null) {
        form.classList.toggle('hidden');
    }
}

function likePost(post) {
    const span = post.querySelector('#tab-like span');
    const checklike = post.querySelector('#tab-like');

    let url = 'like';
    let body = '';

    if (checklike.classList.contains('my-like')) {
        url = 'unlike';
        body = 'unlike=' + post.id;
    }
    else {
        body = 'like=' + post.id;
    }

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: body
    })
    .then(response => response.text())
    .then(data => {
        if (data === '0') {
            span.innerHTML = parseInt(span.innerHTML.replace(/\D/g,'')) - 1 + ' Likes';
            checklike.classList.remove('my-like')
        } else if (data === '1') {
            span.innerHTML = parseInt(span.innerHTML.replace(/\D/g,'')) + 1 + ' Likes';
            checklike.classList.add('my-like')
        }
    })
    .catch(error => {
        console.error('Failed to update like:', error);
    });
}

function commentPost(post) {
    const post_id = post.id;
    window.location = 'post?id='+post_id;
}

function shareLink(post) {
    const post_id = post.id;
    // Get current URL domain
    const link = window.location.origin + '/hakkie/post?id=' + post_id;
    navigator.clipboard.writeText(link)
        .then(() => {
            const shareTab = post.querySelector('#tab-share');
            shareTab.innerHTML = 'Link Copied!';
        })
        .catch((error) => {
            console.error('Failed to copy text: ', error);
        });
}

function deletePost(post) {
    const post_id = post.id;
    fetch('post/delete', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'post_id=' + post_id
    })
    .then(response => response.text())
    .then(data => {
        if (data === '1') {
            post.classList.add('opacity-0', 'scale-0');
            post.addEventListener('transitionend', () => {
                post.remove();
            }, {once: true});
        }
    })
    .catch(error => {
        console.error('Failed to delete post:', error);
    });
}