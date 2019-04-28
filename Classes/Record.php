<?php
include_once('./Database.php');
/**
 * 
 */
class Record
{
	private $record_name;//Name of the record
	private $record_quantity;//Quantity of the record
	private $price_for_each;//Price at which each price was bought


//constructor to be used only when adding new record
	function __construct($record_name,$record_quantity,$price_for_each)
	{
		$this->record_name = $record_name;
		$this->price_for_each = $price_for_each;
		$this->record_quantity = $record_quantity;
	}


	//Method for adding the product

	public function add(){
		Database::add('RECORDS',array($this->record_name,$this->record_quantity,$this->price_for_each));
	}


	///Updating the  record
	public static function update($attr,$new,$pk){
		Database::update('RECORDS',$attr,$new,$pk);
	}

	//Delete record
	public static function delete($pk){
		Database::delete('RECORDS',$pk);
	}
}

$rec = new Record("Book", 25, 256.12);
$rec->add();
	Record::update('RECORD_QUANTITY',120,1);
  ?>