<?php
//Патерн хранит пару ключ - значение, в централизованом хранилище - реестре
//Наиболее правильно реализовывыть через петтерн синглтон, для полноценного ООП а не КОП (классо-оринетированное прогрммирование)

class Registry{
	private $reg = array();
	private static $singletone = null;
	
	private function __construct(){}
	private function __wakeup(){}
	private function __clone(){}
	
	public static function getInstance(){
		if (self::$singletone === null)
			self::$singletone = new static();
		return self::$singletone;
	}
	
	public function set($key, $val){
		self::getInstance()->reg[$key] =  $val;
	}
	
	public function get($key){
		return array_key_exists($key, self::getInstance()->reg) ? self::getInstance()->reg[$key] : null;
	}
		
}

$registry =  Registry::getInstance();
$registry->set('some_var', 'some_value');
echo $registry->get('some_var');
?>