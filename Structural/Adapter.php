<?php
// Паттерн адаптирует несовместимые интерфейсы
// Участники: 
// Adaptee - адаптируемый, с кем надо работать, но с кем не умеем
// iTarget - искомый, с кем умеем работать.
// Adaptee - прослойка
// Сушествуют 2 вида, адаптер адаптер объекта(предпочтительнее) и адаптер класса

interface iAdaptee{
	public function request();
}


interface iTarget{
	public function querry();
}


class Adaptee implements iAdaptee {
	public function request(){
		return 'Some request action';
	}
}

// ---Адаптер объекта, реализует искомый интерфейс, в конструктр получает объект адаптируемого
class AdapterObject implements iTarget{
	private $adaptee;
	
	public function __construct (Adaptee $adaptee){
		$this->adaptee = $adaptee;
	}
	
	public function querry(){
		$temp = $this->adaptee->request();
		return str_replace ('request', 'querry', $temp);
	}
}

$target = new AdapterObject(new Adaptee()); // в адаптер мы передаём объект адаптируемого, на выходе получаем искомый объект
echo $target->querry();

// ---Адаптер класса, реализует искомый интерфейс, но наследуется от адаптируемого (возможны конфликты, класс раздувается и т.д.)
class AdapterClass  extends Adaptee implements iAdaptee{
	public function querry(){
		$temp = parent::request();
		return str_replace ('request', 'querry', $temp);
	}
}
$target2 = new AdapterClass(); 
echo $target2->querry();


?>