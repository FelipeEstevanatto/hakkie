const messageBtn = window.document.querySelector('#message-btn');
const messageSection = window.document.querySelector('#message-section');
const messageButtonIcon = messageBtn.querySelector('i');

messageBtn.addEventListener('click', () => {
    if (messageSection.classList.contains('translate-y-full')) {
        messageSection.classList.remove('translate-y-full');
    } else {
        messageSection.classList.add('translate-y-full');
    }
    messageButtonIcon.classList.toggle('rotate-180');
});