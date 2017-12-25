<?php
// Паттерн гарантирует наличие определённого (именованного) числа экземпляров класса в системе
// Множественный синглтон, или Реестр Одиночек
class Multitone{
	private static $instances = array();
	
	public function getInstance($id){
		if (!isset(static::$instances[$id]))
			static::$instances[$id] = new static();
		return static::$instances[$id];
	}
	
	private function __construct(){}
	private function __clone(){}
	private function __wakeup(){}
	
	public $exampe;
	
}

$obj1 = Multitone::getInstance('one');
$obj1->exampe = 'Some text here 1';
$obj1->exampe = 'Some text here 2';
echo $obj1->exampe;
echo '<br>';
$obj2 = Multitone::getInstance('2');
$obj2->exampe = 'Some text2 here 1';
$obj2->exampe = 'Some text2 here 2';
echo $obj2->exampe;

?>