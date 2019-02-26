<?php
require 'Session.php';
require 'db.php';
require 'Request.php';

$request = new Request;
$errors = [];

$login = trim($_POST['login']);
$password = trim($_POST['password1']);

if ($request->isPost()) {
    $request->required('login')
        ->maxSymbols('login', 36)
        ->minSymbols('login', 3);

    $request->required('password1')
        ->minSymbols('password1', 5);

    $isValid = $request->isValid();
    $errors = $request->getErrors();

    $val = ['login' => $login, 'password' => md5($password)];
    $sql = "SELECT id, login, email, password FROM users WHERE login=:login AND password=:password";
    $rows = $pdo->prepare($sql);
    $rows->execute($val);
    $user = $rows->fetch();

    if (!$user){
        $errors['form'] = 'Такого пользователя не существует либо неверно введен пароль';
        $isValid = false;
    }

    if ($user && empty($errors)) {
        $session = new Session;
        foreach ($user as $key => $value) {
            $session->set($key, $value);
        }
    }


    echo json_encode([
        'status' => $isValid,
        'errors' => $errors,
    ]);
}
