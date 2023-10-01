const messageBtn = window.document.querySelector('#message-btn');
const messageSection = window.document.querySelector('#message-section');

messageBtn.addEventListener('click', () => {
    if (messageSection.classList.contains('translate-y-full')) {
        messageSection.classList.remove('translate-y-full');
        messageButtonIcon.classList.remove('fa-chevron-up');
        messageButtonIcon.classList.add('fa-chevron-down');
    } else {
        messageSection.classList.add('translate-y-full');
        messageButtonIcon.classList.remove('fa-chevron-down');
        messageButtonIcon.classList.add('fa-chevron-up');
    }
});