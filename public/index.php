<?php
// основной код


// $transactions - двумерный массив, вот эта большая таблица, каждый элемент - строка с 4-мя элементами

declare(strict_types = 1);
error_reporting(E_ALL);

/* переноска для проекта. директори сепарэйтор - константа с '/' или '\', зависит от системы
дирнэйм соответственно директория проекта*/

$root = dirname(__DIR__). DIRECTORY_SEPARATOR;


define('APP_PATH', $root . 'app' . DIRECTORY_SEPARATOR);
define('FILES_PATH', $root . 'transaction_files' . DIRECTORY_SEPARATOR);
define('VIEWS_PATH', $root . 'views' . DIRECTORY_SEPARATOR);

//парсинг csv файлов

require APP_PATH . "app.php";
$files = getfiles(FILES_PATH);

// собирает 1 построчный массив переводов из всех файлов
$transactions = [];
foreach ($files as $file){
	$transactions = array_merge($transactions, getTransactions($file, 'extractTransaction'));
}

//считаем 'всего'
$totals = calculateTotals($transactions);

// подключает вёрстку
require VIEWS_PATH . 'transactions.php';
?>