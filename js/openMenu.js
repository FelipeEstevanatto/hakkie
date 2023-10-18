const btn = window.document.querySelector('#ellipsis');
const modal = window.document.querySelector('#ellipsis-modal');

const directMessage = window.document.querySelector('.info .bottom-bar .right .btn#direct_message');

const blockUserBtn = window.document.querySelector('#ellipsis-modal .btn#block_user');
const silenceUserBtn = window.document.querySelector('#ellipsis-modal .btn#silence_user');
const linkUserBtn = window.document.querySelector('#ellipsis-modal .btn#link_user');

btn.addEventListener('click', () => {
    modal.classList.toggle('hidden');
    if(modal.classList.contains('open')) {
        modal.classList.remove('open');
        modal.classList.add('close');

        btn.innerHTML = '<i class="fas fa-ellipsis-v"></i>';
        linkUserBtn.innerHTML = 'Copy Profile Link';    
    }
    else {
        
        modal.classList.add('open');
        modal.classList.remove('close');

        btn.innerHTML = '<i class="fas fa-times"></i>';
    }
});

directMessage.addEventListener('click', () => {
    const messageBtn = window.document.querySelector('#message-btn i');
    const messageSection = window.document.querySelector('#message-section');

    if (messageSection.classList.contains('translate-y-full')) {
        messageSection.classList.remove('translate-y-full');
    } else {
        messageSection.classList.add('translate-y-full');
    }
    messageBtn.classList.toggle('rotate-180');
    
});

if(silenceUserBtn != null && blockUserBtn != null) {
    silenceUserBtn.addEventListener('click', () => {
        console.log("Silence");
    });

    blockUserBtn.addEventListener('click', () => {
        fetch('block', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'user=' + findGetParameter('user')
        })
        .then(response => {
            if (response.ok) {
                return response.text();
            } else {
                throw new Error('Network response was not ok');
        }
        })
        .then(text => {
            if (text === 'Sucess blocking') {
                window.location.reload(true);
            }
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
    });
}

linkUserBtn.addEventListener('click', () => {
    const text = window.location.href;
    navigator.clipboard.writeText(text)
        .then(() => {
            linkUserBtn.innerHTML = 'Link Copied!';
        })
        .catch((error) => {
            console.error('Failed to copy text: ', error);
        });
});