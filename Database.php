<?php

namespace PhpSqlApp;

class Database
{
	private $username = 'root';
	private $password = 'root';
	private $host = 'localhost';
	private $db = 'php_sql_js';
	private $conn;

	public function __construct()
	{
		$this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->db)
			or die("Connection failed: " . mysqli_connect_error());
		echo "Connection open successfully <br>";
	}

	public function query($sql)
	{
		return $this->conn->query($sql);
	}

	public function close()
	{
		$this->conn->close();
		echo "Connection closed<br>";
	}
}
