<?php
require_once 'Database.php';

use PhpSqlApp\Database;

$db = new Database();

$result = $db->query("
    SELECT * FROM sessions
    WHERE id NOT IN (
        SELECT MIN(id)
        FROM sessions
        GROUP BY start_time, session_configuration_id
	)
");

if ($result) {
	echo "Returned rows are: " . $result->num_rows;

	while ($row = mysqli_fetch_assoc($result)) {
		$data[] = $row;
	}

	echo "<pre>";
	print_r($data);
	echo "</pre>";

	$result->free_result();
}

$db->close();
