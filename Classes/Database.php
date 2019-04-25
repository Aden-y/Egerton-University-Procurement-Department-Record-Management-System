<?php 
/**
 * This Class Will Help Connectiong To The MySql DataBase
 *All The methods and variables in this class are static
 */
class Database
{
	
private static $username = 'root';//Username as in the MySql Database. Change appropriately
private static $database_name = 'EUPDRMS'; //Egerton University Procurement Department Record Management system
private static $connection = null;// Connection to the Database. Initially set to null
private static $password = ''; //Password to the database. Change the value as suits
private static $host = 'localhost';//Connection therough the localhost


//This function creats a connection to the database and sets the connection.
//It returns  the connection which can be used in other Classes
//Initial connection before database is created
public static function connectiInitial(){
  try {
    $connection = new PDO("mysql:host=$host", $username, $password);
    // set the PDO error mode to exception
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     return $connection; 
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
    $connection =  new PDO("mysql:host=$host;dbname=$database_name", $username, $password);
    // set the PDO error mode to exception
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     return $connection; 
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
	connectiInitial();//Connect to the database
	//If we were lucky to connect
	if ($connection!=null) {
		$MySql="CREATE DATABASE IF NOT EXISTS ".$database_name;//Create sql query
		$connection->exec($sql);//Execute the query
		$connection = null;//Destroy connection after use
		return true;
	}
	echo "Could not create connection"."<br>";
	return false;
//Cnd of create_db()
}



//Creates all the tables that we will need to use USERS, RECORDS, ORDERS

public  static function createTables(){
	connect();
	if($connection != null){

		//CREATE USERS TABLE
		$sql = "CREATE TABLE IF NOT EXISTS USERS(
		ID INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
		FIRST_NAME VARCHAR(50) NOT NULL,
		LAST_NAME VARCHAR (50) NOT NULL,
		EMAIL VARCHAR (100) NOT NULL,
		USERNAME VARCHAR (50) NOT NULL,
		PASSWORD VARCHAR (250) NOT NULL,
		USER_TYPE ENUM('ADMIN','MANAGER','CLIENT'),
		REGISTER_DATE DATE NOT NULL
	)";
	$connection->exec($sql);//Execute the query
		//CREATE RECORDS TABLE
		$sql = " CREATE TABLE IF NOT EXISTS RECORDS(
			ID INT (11) PRIMARY KEY  NOT NULL AUTO_INCREMENT,
			RECORD_NAME  VARCHAR (100) NOT NULL,
			RECORD_QUANTITY INT(11) NOT NULL,
			PRICE_FOR_EACH FLOAT NOT NULL,
			DATE_ADDED DATE NOT NULL
		)";
		$connection->exec($sql);//Execute the query

	//CREATE ORDERS TABLE

		$sql="CREATE TABLE IF NOT EXISTS ORDERS(
			ID INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
			ITEM_NAME VARCHAR(100) NOT NULL,
			DEPARTMENT_REQUESTING VARCHAR(100) NOT NULL,
			QUANTITY_ORDERING INT (11) NOT NULL,
			ORDER_DATE DATE NOT NULL,/*DATE THE ORDER IS MADE*/
			DATE_TO_DELIVER DATE NOT NULL

		)";
		$connection->exec($sql);//Execute the query
		$connection = null; //Destroy connection
		$sql=null;
	}
//End Create tables
}

//This method adds to the table specified in the argument data array specified in the argument
public static function add($table, $data_array){
	connect();
	if ($connection != null) {
		$today = date("Y/m/d");
		if ($table == 'USERS') {
			$sql="INSERT INTO USERS(FIRST_NAME,LAST_NAME,EMAIL,USERNAME,PASSWORD,USER_TYPE,REGISTER_DATE) VALUES (
			'$data_array[0]','$data_array[1]','$data_array[2]','$data_array[3]','$data_array[4]','$data_array[5],'$today'
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

		$connection->exec($sql);//Execute the query
		$connection = null; //Destroy connection
		$sql=null;
	}

//End add()
}


//RETURNS ALL DATA FROM A TABLE
public static function getAll($table){
	connect();
	if ($connection != null) {	
    $stmt = $connection->prepare("SELECT * FROM '$table'"); 
    $stmt->execute();


  return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}
//End of Class
}


 ?>