<?php
require_once 'Database.php';
require_once 'DataHandler.php';

use PhpSqlApp\Database;
use PhpSqlApp\DataHandler;

$db = new Database();
$dataHandler = new DataHandler($db);

$result = $dataHandler->getDuplicatedSessions();

$count = 0;
if ($result) {
	$count = $result->num_rows;

	$i = 0;
	$session_ids = '';
	while ($row = mysqli_fetch_assoc($result)) {
		if (count($row) - 1 == $i) {
			$session_ids .= $row['id'];
		} else {
			$session_ids .= $row['id'] . ', ';
		}
		$i++;
	}

	$result->free_result();
}

if ($count) {
	$dataHandler->removeDuplicatedSessions();

	echo "Duplicated Sessions rows are: " . $count . '<br>';
	echo "Sessions with id: {$session_ids} was deleted<br>";

	$dataHandler->removeDuplicatedSessionMembers($session_ids);
} else {
	echo 'Duplicated sessions not found<br>';
}

$dataHandler->addUniqueIndexeToSessions();

$db->close();
