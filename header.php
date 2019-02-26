<?php
require 'db.php';

$sql = "SELECT COUNT(id) AS userCount FROM users";
$rows = $pdo->query($sql);
$users = $rows->fetch();

$sql = "SELECT COUNT(id) AS booksCount FROM user_book";
$stm = $pdo->query($sql);
$books = $stm->fetch();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans+Caption" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=ZCOOL+KuaiLe" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <title>Твоя библиотека</title>
</head>
<body>
<header>
    <div class="container">
        <div class="logo">
            <a href="/" class="main__logo">BookStorage</a>
            <a href="/"><span>Онлайн библиотека</span></a>
        </div>
        <div class="info__service">
            <ul>
                <li>Всего пользователей <span><?php echo $users['userCount'] ?></span></li>
                <li>Загружено книг <span><?php echo $books['booksCount'] ?></span></li>
                <li>Онлайн <span>9.700</span></li>
            </ul>
        </div>
    </div>
</header>
