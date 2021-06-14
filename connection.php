<?php
/*
File: connection.php
Description: this defines an object which connects to a database and returns
  a connection to use for queries

*/

Class dbObj{
	/* Database connection start */
	var $servername = "128.199.9.231";
	public $username = "d4brands_app";
	public $password = "vdwei90w4mDSEio342fsmklvds9#fvn_ds";
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
