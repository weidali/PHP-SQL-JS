<?php

namespace PhpSqlApp;

require_once 'Database.php';

class DataHandler
{
	private $db;

	public function __construct(Database $db)
	{
		$this->db = $db;
	}

	public function getDuplicatedSessions()
	{
		$sql = "
			SELECT * FROM sessions
			WHERE id NOT IN (
				SELECT MIN(id)
				FROM sessions
				GROUP BY start_time, session_configuration_id
			)
        ";

		return $this->db->query($sql);
	}

	public function removeDuplicatedSessions()
	{
		$sql = "
			DELETE FROM sessions
			WHERE id NOT IN (
				SELECT id
				FROM (
					SELECT MIN(id) AS id
					FROM sessions
					GROUP BY start_time, session_configuration_id
				) AS tmp
			)
		";

		$this->db->query($sql) or trigger_error($this->db->error() . " " . $sql);
	}

	function removeDuplicatedSessionMembers($session_ids)
	{
		$sql = "
			DELETE FROM session_members
			WHERE session_id IN ($session_ids)
        ";

		$this->db->query($sql) or trigger_error($this->db->error() . " " . $sql);
	}

	public function addUniqueIndexToSessions()
	{
		$isUniqueField = $this->isUniqueField('sessions', 'start_time', $this->db);
		if (!$isUniqueField) {
			$sql = "
				ALTER TABLE sessions
				ADD UNIQUE INDEX idx_unique_session (start_time)
			";

			$this->db->query($sql);
		}
	}

	private function isUniqueField($tablename, $field, $connection)
	{
		$sql = "
			SHOW INDEXES FROM $tablename 
			WHERE Column_name='$field' AND Non_unique=0
		";

		$query = $connection->query($sql);
		if (!mysqli_fetch_assoc($query)) {
			return false;
		}
		return true;
	}
}
