<?php
require_once __DIR__ . '/app/lib/router/Dispatcher.php';

$dispatcher = new Dispatcher();
$dispatcher->setSystemRoot(__DIR__ . '/app');
$dispatcher->setFirstDispatchLevel();
$dispatcher->dispatch();