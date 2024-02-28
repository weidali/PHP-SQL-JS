<?php
require_once 'Database.php';
require_once 'DataHandler.php';

use PhpSqlApp\Database;
use PhpSqlApp\DataHandler;

$db = new Database();
$dataHandler = new DataHandler($db);

$result = $dataHandler->getDuplicatedSessions($db);

$count = 0;
if ($result) {
	$count = $result->num_rows;
	echo "Duplicated Sessions rows are: " . $count . '<br>';

	$i = 0;
	$ids = '';
	while ($row = mysqli_fetch_assoc($result)) {
		if (count($row) - 1 == $i) {
			$ids .= $row['id'];
		} else {
			$ids .= $row['id'] . ', ';
		}
		$i++;
	}

	$result->free_result();
}

if ($count) {
	$dataHandler->removeDuplicatedSessions($db);
	echo "Sessions with id: {$ids} was deleted<br>";
}

$db->close();
