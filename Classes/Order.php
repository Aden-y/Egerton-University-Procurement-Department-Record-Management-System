<?php 
include_once('./Database.php');
/**
 * 
 */
class Order
{
	private $item_name;//name 
	private $department_requesting;//Department requsting for order of the item
	private $quantity_ordering;//Quantity of the item being ordered
	private $date_to_deliver; //Date the item is needed
	function __construct($item_name,$department_requesting,$quantity_ordering,$date_to_deliver)
	{
		$this->item_name = $item_name;
		$this->department_requesting = $department_requesting;
		$this->quantity_ordering = $quantity_ordering;
		$this->date_to_deliver = $date_to_deliver;
	}

	public function add(){
		Database::add('ORDERS',array($this->item_name,$this->department_requesting,$this->quantity_ordering,$this->date_to_deliver));
	}
		public static function update($attr,$new,$pk){
		Database::update('ORDERS',$attr,$new,$pk);
	}
	//Delete record
	public static function delete($pk){
		Database::delete('ORDERS',$pk);
	}
}
//$order = new Order('Petrol','Ingineering',20,date("Y/m/d"));
//$order->add();

 ?>