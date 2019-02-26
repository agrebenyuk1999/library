<?php
require 'Session.php';
$session = new Session();
if (!$_SESSION['id']){
    header('Location: /');
}
$userId = $_SESSION['id'];
require 'header.php';
require 'db.php';


$val = ['id' => $userId];
$sql = "SELECT login FROM users WHERE id=:id";
$rows = $pdo->prepare($sql);
$rows->execute($val);
$user = $rows->fetch();

$val = ['id' => $userId];
$sql = "SELECT user_book.id, description, user_book.date_added AS dateAddBook,
        books.title AS titleBook, books.year_publisher AS bookYear,
        authors.name AS authorName, authors.surname AS authorSurname,
        genres.name AS genre 
        FROM user_book 
        JOIN books ON user_book.book_id=books.id 
        JOIN authors ON author_id=authors.id 
        JOIN genres ON genre_id=genres.id
        WHERE user_book.user_id=:id";
$rows = $pdo->prepare($sql);
$rows->execute($val);
$userBooks = $rows->fetchAll();
?>

<section class="profile" id="profile">
    <div class="welcome">Добро пожаловать в Вашу электронную библиотеку, <?php echo $user['login'] ?></div>
    <div class="quit">
        <a href="./logout.php">Выход из учетной записи</a>
    </div>
    <div class="button__functions">
        <a href="addBook.php" class="add__book__btn">Добавить новую книгу</a>
    </div>
    <div class="my__books">
        <div class="my__books_title">Список Ваших книг:</div>
    </div>
</section>
<section class="books">
    <div class="container">
        <?php foreach ($userBooks as $userBook) {?>
            <div class="book">
                <h3><?php echo $userBook['titleBook']?></h3>
                <ul>
                    <li><span>Жанр:</span><?php echo $userBook['genre']?></li>
                    <li><span>Автор:</span><?php echo $userBook['authorName'] . ' ' . $userBook['authorSurname']?></li>
                    <li><span>Год издания:</span><?php echo $userBook['bookYear']?></li>
                </ul>
                <div><span class="date__add__book">Дата и время добавления: </span><?php echo $userBook['dateAddBook'] ?></div>
                <div class="book__description">Описание книги:</div>
                <p><?php echo $userBook['description']?></p>
                <a href="dellBook.php?id=<?php echo $userBook['id'] ?>">Удалить</a>
            </div>
        <?php } ?>
    </div>
</section>

<?php require 'footer.php'; ?>



