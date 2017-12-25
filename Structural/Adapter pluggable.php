<?php
// Подключаемый адаптер Pluggble Adapter (объекта)
// отличается от обычного адаптера тем, что умеет работать с несколькими адаптируемыми.
interface Target{
	public function get12V();
}

//Адаптируемый класс 1
class Adaptee220{
	public function get220V(){
		return '220 voltage';
	}
}
//Адаптируемый класс 2
class Adaptee110{
	public function get110V(){
		return '110 voltage';
	}
}
//Адаптер
class Adapter implements Target{
	private $adaptee;
	
	public function __construct($adaptee){
		$this->adaptee = $adaptee;
	}
	
	public function get12V(){
		if (is_object($this->adaptee)){
			$class = get_class($this->adaptee);
			if ($class == 'Adaptee220')
				return str_replace('220', '12', $this->adaptee->get220V());
			elseif ($class == 'Adaptee110')
				return str_replace('110', '12', $this->adaptee->get110V());
			else 
				return 'Unknown voltage';
		}
		return 'Unknown voltage';
	}
}


$adapter = new  Adapter(new Adaptee220());
echo $adapter->get12V();// 12 voltage

$adapter = new  Adapter(new Adaptee110());
echo $adapter->get12V(); // 12 voltage

$adapter = new  Adapter(1234);
echo $adapter->get12V(); // Unknown voltage

?>