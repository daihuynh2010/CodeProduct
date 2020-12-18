<?php
if(isset($_GET['CreateTable'])) { 
    CreateTable(); 
} 

if(isset($_POST)) { 
	if (isset($_POST['ID']))
	{
		$ID = $_POST["ID"];
	    GenCode($ID);
	}
} 

function Connection(){
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "wordpress";

	return new mysqli($servername, $username, $password, $dbname);
}

function CreateTable(){
	$conn = Connection();
	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}

	//check table exist
	$exists = $conn->query("select 1 from pl_code_product");

	if($exists !== FALSE)
	{
	   echo("This table exists");
	}else{
	   // sql to create table
		$sql = "CREATE TABLE pl_code_product (
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		id_product VARCHAR(50) NOT NULL,
		code VARCHAR(10) NOT NULL,
		create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
		)";

		if ($conn->query($sql) === TRUE) {
		  echo "Table CodeProduct created successfully";
		} else {
		  echo "Error creating table: " . $conn->error;
		}
	}
	$conn->close();
}

function GenCode($ID){
	$code = FormatCode(rand(0,99999), 5).FormatCode(rand(0,9999), 5);
	$conn = Connection();
	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}
	//check exist
	$exists =(int) mysqli_fetch_row($conn->query("select 1 from pl_code_product where id_product = ".$ID));
	$sql = "";
	if($exists <= 0)
	{
		$sql = "insert into pl_code_product ( id_product, code) values ( ".$ID." , ".$code.")";
	}
	else
	{
		$sql = "update pl_code_product set code = ".$code." where id_product = ".$ID ;
	}

	if ($conn->query($sql) === TRUE) {
		echo $code;
	} else {
		echo "Error GenCode: " . $conn->error;
	}
	$conn->close();
}

function FormatCode($code, $Length){
	$CodeFormat = $code;
	$end = ($Length - strlen((string)$code));
	for($i=0; $i< $end  ; $i++){
		$CodeFormat = "0".$CodeFormat;
	}
	return $CodeFormat;
}