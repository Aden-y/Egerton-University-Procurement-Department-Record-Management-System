<?php 
/**
 * This Class Will HelpDatabase:: Connectiong To The MySql DataBase
 *All The methods and variables in this class are static
 */
class Database
{
	
private static $username = 'root';//Username as in the MySql Database. Change appropriately
private static $database_name = 'EUPDRMS'; //Egerton University Procurement Department Record Management system
private static $connection = null;//Database:: Connection to the Database. Initially set to null
private static $password = ''; //Password to the database. Change the value as suits
private static $host = 'localhost';///Connection therough the localhost


//This function creats aDatabase:: connection to the database and sets theDatabase:: connection.
//It returns  theDatabase:: connection which can be used in other Classes
//InitialDatabase:: connection before database is created
private static function connectiInitial(){
  try {
  	$myhost = Database::$host;
    Database::$connection = new PDO("mysql:host=$myhost", Database::$username, Database::$password);
    // set the PDO error mode to exception
    Database::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     return Database::$connection; 
    }
catch(PDOException $e)
    {
     echo  $e->getMessage(). "<br>";
    return null;
    }
 //End of connect()
}
public static function connect(){
  try {
  	$myhost = Database::$host;
  	$mydb = Database::$database_name;
    Database::$connection =  new PDO("mysql:host=$myhost;dbname=$mydb", Database::$username, Database::$password);
    // set the PDO error mode to exception
    Database::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     return Database::$connection; 
    }
catch(PDOException $e)
    {
     echo  $e->getMessage(). "<br>";
    return null;
    }
 //End of connect()
}

//This Method creates the Database. Of course if it does exist

public static function create_db(){
	Database::connectiInitial();//Connect to the database
	//If we were lucky to connect
	if (Database::$connection!=null) {
		$sql="CREATE DATABASE IF NOT EXISTS ".Database::$database_name;//Create sql query
		Database::$connection->exec($sql);//Execute the query
		Database::$connection = null;//DestroyDatabase:: connection after use
		return true;
	}
	echo "Could not createDatabase:: connection"."<br>";
	return false;
//Cnd of create_db()
}



//Creates all the tables that we will need to use USERS, RECORDS, ORDERS

public  static function createTables(){
	Database::connect();
	if(Database::$connection != null){

		//CREATE USERS TABLE
		$sql = "CREATE TABLE IF NOT EXISTS USERS(
		ID INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
		FIRST_NAME VARCHAR(50) NOT NULL,
		LAST_NAME VARCHAR (50) NOT NULL,
		EMAIL VARCHAR (100) UNIQUE KEY NOT NULL,
		USERNAME VARCHAR (50) UNIQUE KEY NOT NULL,
		PASSWORD VARCHAR (250) NOT NULL,
		USER_TYPE ENUM('ADMIN','MANAGER','CLIENT'),
		REGISTER_DATE DATE NOT NULL
	)";
	Database::$connection->exec($sql);//Execute the query
		//CREATE RECORDS TABLE
		$sql = " CREATE TABLE IF NOT EXISTS RECORDS(
			ID INT (11) PRIMARY KEY  NOT NULL AUTO_INCREMENT,
			RECORD_NAME  VARCHAR (100) UNIQUE KEY NOT NULL,
			RECORD_QUANTITY INT(11) NOT NULL,
			PRICE_FOR_EACH FLOAT NOT NULL,
			DATE_ADDED DATE NOT NULL
		)";
		Database::$connection->exec($sql);//Execute the query

	//CREATE ORDERS TABLE

		$sql="CREATE TABLE IF NOT EXISTS ORDERS(
			ID INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
			ITEM_NAME VARCHAR(100) NOT NULL,
			DEPARTMENT_REQUESTING VARCHAR(100) NOT NULL,
			QUANTITY_ORDERING INT (11) NOT NULL,
			ORDER_DATE DATE NOT NULL,/*DATE THE ORDER IS MADE*/
			DATE_TO_DELIVER DATE NOT NULL

		)";
		Database::$connection->exec($sql);//Execute the query
		Database::$connection = null; //DestroyDatabase:: connection
		$sql=null;
	}
//End Create tables
}

//This method adds to the table specified in the argument data array specified in the argument
public static function add($table, $data_array){
	Database::connect();
	if (Database::$connection != null) {
		$today = date("Y/m/d");
		if ($table == 'USERS') {
			$sql="INSERT INTO USERS(FIRST_NAME,LAST_NAME,EMAIL,USERNAME,PASSWORD,USER_TYPE,REGISTER_DATE) VALUES (
			'$data_array[0]','$data_array[1]','$data_array[2]','$data_array[3]','$data_array[4]','$data_array[5]','$today'
			)";
		}else if($table == 'ORDERS'){
			$sql="INSERT INTO ORDERS(ITEM_NAME,DEPARTMENT_REQUESTING,QUANTITY_ORDERING,ORDER_DATE,DATE_TO_DELIVER) VALUES (
			'$data_array[0]','$data_array[1]','$data_array[2]','$today','$data_array[3]'
			)";
		}else if ($table =='RECORDS' ) {
			$sql="INSERT INTO RECORDS(RECORD_NAME,RECORD_QUANTITY,PRICE_FOR_EACH,DATE_ADDED) VALUES (
			'$data_array[0]','$data_array[1]','$data_array[2]','$today'
			)";
		}

		Database::$connection->exec($sql);//Execute the query
		Database::$connection = null; //DestroyDatabase:: connection
		$sql=null;
	}

//End add()
}


//RETURNS ALL DATA FROM A TABLE
public static function getAll($table){
	Database::connect();
	if (Database::$connection != null) {	
    $stmt = Database::$connection->prepare("SELECT * FROM $table"); 
    $stmt->execute();


  return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}


/*
*This function is used to update the table given in the argument.
*@param table  is the table to update
*@param attr is the attribute we want to update
*@param  new is the new value we want for the attribute
*@param pk The value in the primary key
*/
public static  function update($table, $attr, $new, $pk){
		Database::connect();
	if (Database::$connection != null) {	
		$sql= "UPDATE $table SET $attr = '$new' WHERE ID = '$pk'";
		Database::$connection->exec($sql);//Execute the query
		Database::$connection = null; //DestroyDatabase:: connection
		$sql=null;
	}
}

//Deleting record from the Database

public static function delete($table, $pk){
	Database::connect();
	if (Database::$connection != null) {	
		$sql= "DELETE FROM $table  WHERE ID = '$pk'";
		Database::$connection->exec($sql);//Execute the query
		Database::$connection = null; //DestroyDatabase:: connection
		$sql=null;
	}
}

//End of Class
}
 //Database::create_db();
//Database::createTables();
//print_r(Database::getAll('USERS'));echo "<br>";
//print_r(Database::getAll('RECORDS'));echo "<br>";
//print_r(Database::getAll('ORDERS'));echo "<br>";

 ?>