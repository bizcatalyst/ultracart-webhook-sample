<?php
/*
File: connection.php
Description: this defines an object which connects to a database and returns
  a connection to use for queries

*/

Class dbObj{
	/* Database connection start */
	var $servername = "128.199.9.231";
	public $username = "app";
	public $password = "4eea2aba0a90185cf370764d20fc4b1dd2d9aa996872905f";
	var $dbname = "d4brands";
	var $conn;
	function getConnstring() {
		$con = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname) or die("Connection failed: " . mysqli_connect_error());

		/* check connection */
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		} else {
			$this->conn = $con;
		}
		return $this->conn;
	}
}
