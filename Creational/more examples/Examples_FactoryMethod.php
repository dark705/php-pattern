<?php
abstract class Lamp{
	public static function getLamp($type){
		return new $type;
	}
	
	abstract public function show();
}

class SimpleLamp extends Lamp{
	public function show(){
		echo "Этот объект обычная лампа<br>\n";
	}
}

class SaverLamp extends Lamp{
	public function show(){
		echo "Этот объект энергосберегающая лампа<br>\n";
	}
}

class LedLamp extends Lamp{
	public function show(){
		echo "Этот объект светодиодная лампа<br>\n";
	}
}
//Все три объекта получены статическим фабричным методом
$simple_lamp = Lamp::getLamp('SimpleLamp');
$saver_lamp = Lamp::getLamp('SaverLamp');
$led_lamp = Lamp::getLamp('LedLamp');

//При этом все объекты относятся к разным классам, имея однако одинаковый интерфейс
$simple_lamp->show();
$saver_lamp->show();
$led_lamp->show();
?>