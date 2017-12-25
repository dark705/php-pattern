<?php
//Паттерн создаёт клоны объектов
//При этом мы не вдаёмся в подробности реализации, а вызываем метод clone(), который возвращает клон существующего объекта
abstract class Prototype{
	protected $serial;
	abstract function get();
	
	public function __construct($size, $color, $label, $serial = 0){
		$this->size = $size;
		$this->color = $color;
		$this->label = $label;
		$this->serial = $serial;
	}
}

//Первый метод реализации патерна - в лоб.
class ColaPrototype extends Prototype{
	
		
	//т.е. мы инстанцируем наш класс, с заданными параметрами, которые остались у прототипа
	public function getClone(){
		// если надо, то совершаем дополнительные действия над клоном,
		// Задаём параметры клонирования
		$proto = new self($this->size, $this->color, $this->label, ++$this->serial);
		return  $proto;
	}

	public function get(){
		return
		"
		<div style='float: left; margin:10px; border: 5px solid black; width: 100px; height: $this->size ; position: relative; bottom: 0px; text-align: center;'>
			<div style='height: 85%; width:100%; position: absolute; bottom: 0; background-color: $this->color'></div>
			<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: red'></div>
			<div style='height: 50px;; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>$this->label</h4></div>
			<div style='width:100%; height: 10px; position: absolute; bottom: 10px; z-index: 20;'>$this->serial</div>
		</div>
		";
		}
}
//Создаём объект прототип
$cola_prototype = new ColaPrototype('500px', 'brown', 'Colla');
//Создаём клонов
for ($i = 1; $i <= 5; $i++){
	$cola = $cola_prototype->getClone();
	echo $cola->get();
}

//Второй способ реализации - использовать встроенные средства PHP
class FantaPrototype extends Prototype{
	protected static $num = 1;
	public function get(){
		return
		"
		<div style='float: left; margin:10px; border: 5px solid black; width: 80px; height: $this->size ; position: relative; bottom: 0px; text-align: center;'>
			<div style='height: 85%; width:100%; position: absolute; bottom: 0; background-color: $this->color'></div>
			<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: green'></div>
			<div style='height: 50px; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>$this->label</h4></div>
			<div style='width:100%; height: 10px; position: absolute; bottom: 10px; z-index: 20;'>$this->serial</div>
		</div>
		";
		}
	public function __clone(){
		// если надо, то совершаем дополнительные действия над клоном,
		// Задаём параметры клонирования
		$this->serial = ++self::$num;
	}
}

$fanta_prototype = new FantaPrototype('370px', 'orange', 'Fanta');
for ($i = 1; $i <= 3; $i++){
	$fanta = clone $fanta_prototype;
	echo $fanta->get();
}


// Основная задача патерна состоит в том чтобы сделать класс для создания объекта прототипа, 
// а потом уже клонировать его либо средствами самого класса через специальный метод (в котором взывается new self(...)), либо средствами языка в PHP через clone
// При этом мы не в даёмся в подробности реализации клонирования, а просто вызываем соотвествующий метод обеспечивающий это


?>