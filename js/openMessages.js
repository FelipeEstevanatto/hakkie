const messageBtn = window.document.querySelector('#message-btn');
const messageSection = window.document.querySelector('#message-section');

messageBtn.addEventListener('click', () => {
    if(messageBtn.classList.contains('message-btn-close')) {
        messageBtn.classList.remove('message-btn-close');
        messageBtn.classList.add('message-btn-open');

        messageSection.classList.remove('message-section-close');
        messageSection.classList.add('message-section-open'); 
    }
    else {
        messageBtn.classList.remove('message-btn-open');
        messageBtn.classList.add('message-btn-close');

        messageSection.classList.remove('message-section-open');
        messageSection.classList.add('message-section-close');
    }
});