

// операции с друзьями !!!!!!!!!!!!!!!!!!

document.addEventListener('DOMContentLoaded', function () {
    
    function handleAddFriendClick(event) {
        const button = event.target;
        const friendId = button.dataset.friendId; 

        button.disabled = true; 
        button.textContent = "Отправка...";

        fetch(button.dataset.url, { 
            method: 'POST',
            body: JSON.stringify({ friendId: parseInt(friendId, 10) }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errData => {
                        throw new Error(errData.error || 'Ошибка сервера');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    console.log('Друг добавлен!');
                    button.textContent = "Запрос отправлен";
                  
                } else {
                    console.error('Ошибка при добавлении друга:', data.error);
                    alert('Ошибка: ' + (data.error || 'Попробуйте позже.'));
                    button.disabled = false;
                    button.textContent = "Друг уже добавлен";
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
                alert('Ошибка: ' + error.message);
                button.disabled = false;
                button.textContent = "Добавить в друзья";
            });
    }

    
    const addFriendButtons = document.querySelectorAll(".add-friends-button, .add-friend-button, .delete-friend-button .remove-friend-button");


    addFriendButtons.forEach(button => {
        button.addEventListener('click', handleAddFriendClick);
       
        if (button.classList.contains('add-friend-button')) {
            button.dataset.url = '/ajax/accept_ajax.php';
        }
        else if (button.classList.contains('add-friends-button')) {
            button.dataset.url = '/add_friend.php';
        }
        else if (button.classList.contains("delete-friend-button")) {
            button.dataset.url = '/ajax/del_ajax.php';
        }
        else if (button.classList.contains("remove-friend-button")) {
            button.dataset.url = '/ajax/remove_ajax.php'; 
        }
    });


});