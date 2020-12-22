<?php
require_once ('../../../wp-config.php');

if(isset($_GET['CreateTable'])) { 
    CreateTable(); 
} 

if(isset($_GET['CreateTableStatic'])) { 
    CreateTableStatic(); 
} 

if(isset($_POST)) { 
	if (isset($_POST['ID']))
	{
		$ID = $_POST["ID"];
	    GenCode($ID);
	}
} 

if(isset($_POST)) { 
	if (isset($_POST['Data']))
	{
		$Code = $_POST["Data"];
	    CheckCodeProduct($Code);
	}
} 

if(isset($_POST)) { 
	if (isset($_POST['NumberofEnter']))
	{
		$Number = $_POST["NumberofEnter"];
	    SaveSetting($Number);
	}
} 

function Connection(){
	$servername = DB_HOST;//"localhost";
	$username = DB_USER;//"root";
	$password = DB_PASSWORD;//"";
	$dbname = DB_NAME;//"wordpress";

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
		count_enter INT,
		create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
		) ";

		//

		if ($conn->query($sql) === TRUE) {
		  echo "Table CodeProduct created successfully";
		} else {
		  echo "Error creating table: " . $conn->error;
		}
	}
	$conn->close();
}

function CreateTableStatic(){
	$conn = Connection();
	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}

	//check table exist
	$exists = $conn->query("select 1 from pl_static_data");

	if($exists !== FALSE)
	{
	   echo("This table exists");
	}else{
	   // sql to create table
		$sql = "CREATE TABLE pl_static_data(
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		name VARCHAR(100) NOT NULL,
		value VARCHAR(50) NOT NULL,
		create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
		) ";

		//

		if ($conn->query($sql) === TRUE) {
		  echo "Table CodeProduct created successfully";
		} else {
		  echo "Error creating table: " . $conn->error;
		}
	}
	$conn->close();
}

function GenCode($ID){
	$code = FormatCode(rand(0,999999), 6).FormatCode(rand(0,999), 3);
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

function CheckCodeProduct($Code){
	$conn = Connection();
	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}

	//check table exist
	$sql = "select 1 from pl_code_product where code = '".$Code."'";
	$sqlCount = "select 1 from pl_code_product where count_enter is null or count_enter <= (select value from pl_static_data where name = 'NumberOfEnter')";
	$result = (int) mysqli_fetch_row($conn->query($sql));
	

	if($result > 0)
	{
		$resultCount = (int) mysqli_fetch_row($conn->query($sqlCount));
		if($resultCount > 0){
			$sqlUpdate = "update pl_code_product set count_enter = COALESCE(count_enter,0) + 1 where code = '".$Code."'" ;
			if ($conn->query($sqlUpdate) === TRUE) {
	   			echo("Product exists");
	   		}
	   		else
	   		{
	   			//echo("Error check code product, try again!");
	   			echo ($code);
	   		}
	    }
	    else
	    {
	    	echo("Number Of Enter is max");
	    }
	}else{
	   echo("Product not exists");
	}
	$conn->close();
}

function SaveSetting($Number){
	$conn = Connection();
	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}
	//check exist
	$exists =(int) mysqli_fetch_row($conn->query("select 1 from pl_static_data where name = 'NumberOfEnter'"));
	$sql = "";
	if($exists <= 0)
	{
		$sql = "insert into pl_static_data ( name, value) values ( 'NumberOfEnter' , ".$Number.")";
	}
	else
	{
		$sql = "update pl_static_data set value = ".$Number." where name = 'NumberOfEnter'" ;
	}

	if ($conn->query($sql) === TRUE) {
		echo "Save Success";
	} else {
		echo "Error GenCode: " . $conn->error;
	}
	$conn->close();
}