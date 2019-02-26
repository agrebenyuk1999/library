<?php
require 'Session.php';
require 'db.php';
require 'Request.php';

$request = new Request;
$errors = [];

$login = trim($_POST['login']);
$email = trim($_POST['email']);
$password = trim($_POST['password1']);
$regDate = date('Y-m-d H:i:s');

$val = ['login' => $login];
$sql = "SELECT id, login FROM users WHERE login=:login";
$rows = $pdo->prepare($sql);
$rows->execute($val);
$users = $rows->fetch();

if ($request->isPost()) {
    $request->required('login')
            ->maxSymbols('login', 36)
            ->minSymbols('login', 3);

    $request->required('email')
            ->correctEmail('email');

    $request->required('password1')
            ->minSymbols('password1', 5);

    $request->passwordConfirm('password1', 'password2')
            ->required('password2');

    $isValid = $request->isValid();
    $errors = $request->getErrors();

    if ($users['login']) {
        $isValid = false;
        $errors['form'] = 'Пользователь с таким логином уже существует';
    }

    if ($isValid === true) {
        $val = ['login' => $login, 'email' => $email, 'password' => md5($password), 'reg_date' => $regDate];
        $sql = "INSERT INTO users SET login=:login, email=:email, password=:password, reg_date=:reg_date";
        $rows = $pdo->prepare($sql);
        $rows->execute($val);

        $session = new Session;
        $session->set('login', $login);
        $session->set('password', $password);
    }

    echo json_encode([
        'status' => $isValid,
        'errors' => $errors,
    ]);
}
