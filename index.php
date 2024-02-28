<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$servername = 'localhost';
$db = 'php_sql_js';
$username = 'root';
$password = 'root';

$conn = mysqli_connect($servername, $username, $password, $db) or die("Connection failed: " . mysqli_connect_error());

echo "Connected successfully <br>";

$result = $conn->query("
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

echo "Connection closed<br>";
$conn->close();
