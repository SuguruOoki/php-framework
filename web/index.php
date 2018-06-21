<?php

require_once(__DIR__ . '/app/lib/router/Dispatcher.php');
require_once(__DIR__ . '/app/lib/session/Session.php');

$dispatcher = new Dispatcher();
$session    = new Session();

$dispatcher->setSystemRoot(__DIR__ . '/app');
$dispatcher->setPramLevel(0);
// TODO: ここのkeyとvalueは今度書き換えします。
$session->start('sample', 'samples');
try {
    $dispatcher->dispatch();
} catch(Exception $e) {
    echo 'エラー：' . $e;
}


