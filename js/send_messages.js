
const messageForm = document.querySelector('.message-form');
const messageInput = messageForm.querySelector('textarea');
const sendMessageButton = messageForm.querySelector('.send-message-btn');

sendMessageButton.addEventListener('click', () => {
    const message = messageInput.value.trim();
    const companionId = messageForm.dataset.companionId;;

    if (message !== '') {
        fetch('/messages/send_message.php', { 
            method: 'POST',
            body: JSON.stringify({ companionId: parseInt(companionId, 10), message }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(response => {
                if (response.ok) {
                    return response.text();
                } else {
                    throw new Error('Ошибка отправки сообщения');
                }
            })
            .then(response => {
    
                messageInput.value = '';

            })
            .catch(error => {
                console.error('Ошибка:', error);
            });
    }
});


