<?php
// библеотека функций для основного скрипта

declare(strict_types = 1);



/* принимает константы с путями директорий, ищет файлы, если в папке папка - пропускает, если файл - добавляет в массив.
 $files - массив с путями к файлам */

function getfiles(string $dirPath): array
{
	$files = [];

	foreach(scandir($dirPath) as $file) {
		if(is_dir($file)){
			continue;
		}

		$files[] = $dirPath . $file;
	}
	
	return $files;
}





/*берёт csv файл и возвращает построчный массив. + коллабл позволяет дополнительно применить функцию (в моём случае в индекс укажу extractTransactions) */
function getTransactions(string $filename, ?callable $transactionHandler = null): array
{
	// если файла нет:
	if (! file_exists($filename)){
		// имитируем ошибку
		trigger_error('File "' . $filename . '" does not exist.', E_USER_ERROR);
	}

	$file = fopen($filename, 'r');
	$transactions = [];

	fgetcsv($file);// читаем первую строку, т.к там просто описание столбцов

	//конструкция построчного чтения
	while (($transaction = fgetcsv($file)) !== false){
		if ($transactionHandler !== null){
			$transactions[] = $transactionHandler($transaction);
		}
		$transactions[] = $transaction;
	}
	return $transactions; // массив, где каждая строка - элемент
}




/*
наш csv файл is ass, неудобный, ну типа он конечно делится на элементы, но какие:

03/02/2026,1001,Supermarket Groceries,"-$145.20"

некрасивая дата, чек нормальный, описание пойдёт, сумма вообще в ковычках и с долларом. extractTransactions должен это преобразовать
*/

function extractTransaction(array $transactionRow): array
{	
	[$date, $checknumber, $description, $amount] = $transactionRow;
	$amount = (float) str_replace(['$', ','], '', $amount);
	$date = date('M j, Y', strtotime($date));
	return [
		'date'        => $date,
		'checknumber' => $checknumber,
		'description' => $description,
		'amount'      => $amount,
		];
}



// подсчёт "всего, всего потрачено, всего получено"

function calculateTotals(array $transactions) :array
{
	// массив с 3-мя накопителями
	$totals = ['netTotal' => 0, 'totalIncome' => 0, 'totalExpense' => 0];

	foreach ($transactions as $transaction) {
		$totals['netTotal'] += $transaction['amount'];

		if ($transaction['amount'] >= 0) {
			$totals['totalIncome'] += $transaction['amount'];
		} else{ 
			$totals['totalExpense'] += $transaction['amount'];
		}
	}
	return $totals;
}

?>