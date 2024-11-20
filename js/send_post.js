
// ПОСТЫ


document.addEventListener('DOMContentLoaded', function () {
    const postForm = document.querySelector('.post-form form');

  
    postForm.addEventListener('submit', function (event) {
        event.preventDefault(); 

  
        const formData = new FormData(postForm);

        const data = {
            author_id: formData.get('user_id'),
            receiver_id: formData.get("receiver_id"),
            text: formData.get('text'),
            image: formData.get('image') 
        };


        fetch('/post/add_post.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json' 
            },
            body: JSON.stringify(data) 
        })
            .then(response => {
                if (response.ok) {
                   
                    postForm.reset(); 
                    alert('Пост успешно добавлен');
                    updatePostList();
                } else {
                 
                    console.error('Ошибка отправки поста');
                }
            })
            .catch(error => {
                console.error('Ошибка отправки поста:', error);
            });
    });
});