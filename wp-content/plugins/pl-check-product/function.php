<?php
require_once ('../../../wp-config.php');

if(isset($_GET['CreateTable'])) { 
    CreateTable(); 
} 

if(isset($_GET['CreateTableStatic'])) { 
    CreateTableStatic(); 
} 

if(isset($_POST)) { 
	if (isset($_POST['Range']))
	{
		$Range = $_POST["Range"];
	    GenCode($Range);
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
		code VARCHAR(50) NOT NULL,
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

function GenCode($Range = 0){
	// $code = FormatCode(rand(0,999999), 6).FormatCode(rand(0,999), 3);
	$characterNumber = '0123456789';
	$characterString = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$conn = Connection();
	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}

	$i=0;
	while ($i < $Range) {
		$code = generateRandomString($characterNumber,6)."-".generateRandomString($characterString,3);
		//check exist
		$exists =(int) mysqli_fetch_row($conn->query("select 1 from pl_code_product where code = ".$code));
		$sql = "";
		if($exists <= 0)
		{
			$sql = "insert into pl_code_product (code) values ( ".$code.")";
		}
		
		if ($conn->query($sql) === TRUE) {
			$i++;
		} 
	}

	// if ($conn->query($sql) === TRUE) {
	// 	echo $code;
	// } else {
	// 	echo "Error GenCode: " . $conn->error;
	// }
	$conn->close();
}

function generateRandomString($characters, $length) {
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
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
		echo "Error SaveSetting: " . $conn->error;
	}
	$conn->close();
}