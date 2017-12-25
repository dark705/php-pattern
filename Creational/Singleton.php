<?php
// Патерн гарантирует наличие только одного экземпляра класса в системе, 
// При этом обращение происходит: Singleton::getInstance()
class Singleton{
	private static $instance;
	
	public $some;
	
	public static function getInstance(){
		if ((static::$instance) === null)
			static::$instance = new static();
		return static::$instance;
	}
	
	public function showClassName(){
		echo get_class(self::$instance);
	}
	
	private function __construct(){}
	private function __clone(){}
	private function __wakeup(){}
}


$singletone_obj1 = Singleton::getInstance();
$singletone_obj2 = Singleton::getInstance();
//повторное инстанцирование класса, вернёт объект который уже был создан создан в первый раз.


$singletone_obj1->some = 'Some text1';
$singletone_obj2->some = 'Some text2';

echo $singletone_obj1->some;
echo '<br>';
echo $singletone_obj2->some;
echo '<br>';

$singletone_obj2->showClassName();


?>