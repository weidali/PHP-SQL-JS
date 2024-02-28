<?php

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
	),
	MYSQLI_USE_RESULT
");

if ($result) {
	echo "Returned rows are: " . $result->num_rows;
	$result->free_result();
}


echo "Connection closed<br>";
$conn->close();
