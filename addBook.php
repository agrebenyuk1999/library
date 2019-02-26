<?php
require 'Session.php';
$session = new Session;
$userId = $_SESSION['id'];
require 'header.php';
require 'Request.php';

$sql = "SELECT id, name FROM genres";
$rows = $pdo->query($sql);
$genres = $rows->fetchAll();

$request = new Request;
if ($request->isPost()) {
    $errors = [];
    $request->required('title');
    $request->required('author_name');
    $request->required('author_surname');
    $request->selectIsNotEmptyValues('genre');
    $request->required('year');
    $request->isNumber('year');
    $request->required('description');
    $isValid = $request->isValid();
    $errors = $request->getErrors();

    if (empty($errors)){
        $bookTitle = $_POST['title'];
        $bookAuthorName = $_POST['author_name'];
        $bookAuthorSurname = $_POST['author_surname'];
        $bookGenre = $_POST['genre'];
        $bookYearPublisher = $_POST['year'];
        $bookDescription = $_POST['description'];

        $val = ['name' => $bookAuthorName, 'surname' => $bookAuthorSurname];
        $sql = "INSERT INTO authors SET name=:name, surname=:surname";
        $rows = $pdo->prepare($sql);
        $rows->execute($val);

        $val = ['name' => $bookAuthorName, 'surname' => $bookAuthorSurname];
        $sql = "SELECT id, name, surname FROM authors WHERE name=:name AND surname=:surname";
        $rows = $pdo->prepare($sql);
        $rows->execute($val);
        $author = $rows->fetch();
        $authorId = $author['id'];

        $val = ['title' => $bookTitle, 'year_publisher' => $bookYearPublisher, 'genre_id' => $bookGenre, 'author_id' => $authorId];
        $sql = "INSERT INTO books SET title=:title, genre_id=:genre_id, author_id=:author_id, year_publisher=:year_publisher";
        $rows = $pdo->prepare($sql);
        $rows->execute($val);

        $sql = "SELECT id FROM books ORDER BY id DESC";
        $rows = $pdo->query($sql);
        $book = $rows->fetch();
        $bookId = $book['id'];

        $val = ['user_id' => $userId, 'book_id' => $bookId, 'description' => $bookDescription, 'date_added' => date('Y-m-d H:i:s')];
        $sql = "INSERT INTO user_book SET user_id=:user_id, book_id=:book_id, description=:description, date_added=:date_added";
        $rows = $pdo->prepare($sql);
        $rows->execute($val);
    }
}

?>
<section class="registration add__book" id="registration">
    <div class="container" id="app">
        <div class="reg__form" id="reg__form">
            <a href="/" class="back__main">Вернуться к списку книг</a>
            <div class="head__form__title">Добавление книги</div>
            <form method="post">
                <div><input type="text" name="title" placeholder="Название книги"></div>
                <span><?php echo $errors['title'] ? $errors['title'][0] : '' ?></span>
                <div><input type="text" name="author_name" placeholder="Имя автора"></div>
                <span><?php echo $errors['author_name'] ? $errors['author_name'][0] : '' ?></span>
                <div><input type="text" name="author_surname" placeholder="Фамилия автора"></div>
                <span><?php echo $errors['author_surname'] ? $errors['author_surname'][0] : '' ?></span>
                <select name="genre">
                    <option disabled selected>Выберите жанр</option>
                    <?php foreach ($genres as $genre) {?>
                        <option value="<?php echo $genre['id']; ?>"><?php echo $genre['name']; ?></option>
                    <?php } ?>
                </select>
                <span><?php echo $errors['genre'] ? $errors['genre'][0] : '' ?></span>
                <div><input type="text" name="year" placeholder="Год публикации"></div>
                <span><?php echo $errors['year'] ? $errors['year'][0] : '' ?></span>
                <div><textarea name="description" placeholder="Описание"></textarea></div>
                <span><?php echo $errors['description'] ? $errors['description'][0] : '' ?></span>
                <div><button type="submit">Добавить</button></div>
            </form>
        </div>
    </div>
</section>
<?php require ('footer.php')?>
