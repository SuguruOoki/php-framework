<?php 

session_start();

if (isset($_SESSION['email'])) {
    echo 'ようこそ'.$_SESSION['email'].'さん';
} else {
    header('Location: /');
    exit();
}