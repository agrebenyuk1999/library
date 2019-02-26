<?php
require 'Session.php';
$session = new Session;
if ($_SESSION['id']){
    header('Location: profile.php');
}
require 'header.php';
$session = new Session();
?>

    <section class="info" id="info">
        <div class="container">
            <h1>Bookstorage</h1>
            <p>Bookstorage - это твоя онлайн библиотека, с помощью которой ты можешь хранить книги и информацию о всех своих
                прочитанных произведениях, обсуждать их с другими пользователями, читать отзывы других людей. Сервис позволяет создать
                список, в который можно добавлять книги, которые ты собираешься прочитать в будущем, чтобы не забыть о них.
                Bookstorage объединяет тысячи любителей чтения книг, начни прямо сейчас!
            </p>
            <div class="registration__login">
                <a href="registration.php" class="reg__btn">Зарегистрироваться</a>
                <a href="login.php" class="login__btn">Вход</a>
                <span>Авторизируйтесь, если у Вас уже есть аккаунт</span>
            </div>
        </div>
    </section>
<?php require ('footer.php')?>
