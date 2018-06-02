<?php

require_once('UserValidator.php');

session_start();

$posted_email = $_POST["email"];
$posted_password = $_POST["password"];

$validator = new UserValidator();
$check_columns = ['email' => $posted_email, 'password' => $posted_password];

if ($validator->validateDuplicate($check_columns) === true) {
    // ログイン成功
    $_SESSION['email'] = $check_columns['email'];
    header('Location: /app/home.php');
    exit();
} else {
    // ログイン失敗
    header('Location: /');
    exit();
}