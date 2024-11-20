<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ title }}</title>
    <link rel="stylesheet" href="/css/style.css"> 
</head>
<body>

    <header>
        <div class="container">
            <div class="header-content">
                <h1><a href="/">Вместе</a></h1>
<form name="search" class="search-form" method="POST" action="search.php">
    <input type="search" name="query" placeholder="Поиск">
    <button type="submit">Найти</button> 
</form>
     
                <div class="user-menu">
                    <?php if (isset($user)): ?>
                        <a href="/profile/{{ user.id }}"><?php echo $user['username']; ?></a>
                        <a href="/logout">Выйти</a>
                    <?php else: ?>
                        <a href="/login">Войти</a>
                        <a href="/register">Регистрация</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <main>
    
            {{ content }}
       
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 Вместе</p>
        </div>
    </footer>
<script src="js/script.js" defer></script>
<script src="/js/send_messages.js" defer></script>
<script src="/js/send_post.js" defer></script>
</body>
</html>