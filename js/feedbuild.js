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
const post_ids = doc.querySelectorAll('#feed .post');
const user_ids = doc.querySelectorAll('#feed .post .top-post .left');
const interativeForm = doc.querySelectorAll('.interative-form');

console.log(post_ids)
const feed = doc.getElementById('feed');

feed.addEventListener('click', (event) => {
    const target = event.target;
    if (target.matches('#feed .post .top-post .right i.fas.fa-ellipsis-v')) {
        const post = target.closest('.post');
        const form = post.querySelector('.interative-form');

        if (form.classList.contains('open')) {
            form.classList.remove('open');
            form.classList.add('close');
        } else {
            form.classList.add('open');
            form.classList.remove('close');

            const followBtn = form.querySelector('#follow');
            const blockBtn = form.querySelector('#block');
            const deleteBtn = form.querySelector('#delete');
            const postId = post.id;
            const userId = post.querySelector('.top-post .left').id;

            followBtn.addEventListener('click', () => {
                // Handle follow button click
                fetch('followLogic', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'follow=' + userId
                })
                .then(response => response.text())
                .then(data => {
                    if (data === '0') {
                        followBtn.innerHTML = 'Follow';
                    } else if (data === '1') {
                        followBtn.innerHTML = 'Unfollow';
                    }
                })
                .catch(error => {
                    console.error('Failed to update follow:', error);
                });
                
            });

            blockBtn.addEventListener('click', () => {
                // Handle block button click
                
            });

            deleteBtn.addEventListener('click', () => {
                // Handle delete button click
            });
        }
    }
});

feed.addEventListener('click', (event) => {
    const target = event.target;
    if (target.classList.contains('likebtn')) {
        const index = Array.from(target.parentNode.parentNode.parentNode.children).indexOf(target.parentNode.parentNode);
        const span = doc.querySelectorAll('#feed .post .bottom-post .list #tab-like span');
        const checklike = doc.querySelectorAll('#feed .post .bottom-post .list #tab-like');

        let url = 'likeLogic';
        let body = '';

        if (checklike[index].classList.contains('my-like')) {
            body = 'unlike=' + post_ids[index].id;
        } else {
            body = 'like=' + post_ids[index].id;
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
                span[index].innerHTML = parseInt(span[index].innerHTML.replace(/\D/g,'')) - 1 + ' Likes';
                checklike[index].classList.remove('my-like')
            } else if (data === '1') {
                span[index].innerHTML = parseInt(span[index].innerHTML.replace(/\D/g,'')) + 1 + ' Likes';
                checklike[index].classList.add('my-like')
            }
        })
        .catch(error => {
            console.error('Failed to update like:', error);
        });
    }
});

commentbtn.forEach((btn, index) => {
    btn.addEventListener('click', () => {

        var post_id = post_ids[index].id;

        window.location = 'post?id='+post_id;
    });
});

sharebtn.forEach((btn, index) => {
    btn.addEventListener('click', () => {
        const post_id = post_ids[index].id;
        const link = `/post?id=${post_id}`;
        navigator.clipboard.writeText(link)
            .then(() => {
                const shareTab = doc.querySelectorAll('#feed .post .bottom-post .list #tab-share')[index];
                shareTab.innerHTML = 'Link Copied!';
            })
            .catch((error) => {
                console.error('Failed to copy text: ', error);
            });
    });
});