<?php
include_once('./Database.php');
/**
 * This class represent a user of the system
 */
class User
{
	
private $first_name;//First name of the user
private $last_name;//last name of the user
private $email;//Email of the user
private $username; //Username for accessing the system
private $password; //Password for the system

private $user_type; //Usertype admin, client or record manager


//Create a constructor
	function __construct($first_name,$last_name,$email,$username, $password,$user_type)
	{
		$this->first_name=$first_name;
		$this->last_name=$last_name;
		$this->email=$email;
		$this->username=$username;
		$this->password= password_hash($password, PASSWORD_DEFAULT);//Hash the password
		$this->user_type=$user_type;
		
	}

	public function add(){
		Database::add('USERS',array($this->first_name,$this->last_name,$this->email,$this->username,$this->password,$this->user_type));
	}


	public static function login($email_username, $password){

	}

	
}

//$user = new User('Joakim','Adeny','kimmiejoe92@gmail.com','mrkim','kimkim','ADMIN');
//$user->add();
  ?>