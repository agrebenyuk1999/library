<?php
require 'db.php';
$id = $_GET['id'];

$val = ['id' => $id];
$sql = "DELETE FROM user_book WHERE id=:id";
$rows = $pdo->prepare($sql);
$rows->execute($val);
header('Location: /');
