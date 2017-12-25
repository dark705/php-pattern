<?php
//Паттерн отделяет абстрацию от реализации.
//2 основных участника:
// Абстракция - некоторое условное действие, объект, данные и т.д.
// Реализация - то как мы это реализуем
//Методы в реализация должны иметь один интерфейс

// В абстракции идёт обращении к реализации
abstract class Abstraction{
	protected $implementer;
	
	public function __construct ($implementer){
		$this->implementer = $implementer;
	}
	
	public function getWater(){
		return $this->implementer->getWater();
	}
	public function getShell($water){
		return $this->implementer->getShell($water);
	}
	
}
// Refined Abstraction, т.е. в рафинированой (очищенной) абстракции уже нет упоминаний об имплементации (реализации). 
// в ней есть отсылы к абстракции.
class Drink extends Abstraction{
	public function get(){
		return $this->getShell($this->getWater());
	}
}
//В имплементации происходит реализация некоторых абстрактных действий, вычислений и т.д.
interface Implementer{
	public function getWater();
	public function getShell($fill);
}

class Cola implements Implementer{
	public function getWater(){
		return
		"
		<div style='height: 80%; width:100%; position: absolute; bottom: 0; background-color: brown'></div>
		<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: red'></div>
		<div style='height: 10%; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>Colla</h4></div>
		";
	}
	
	public function getShell($fill){
		return
		"
		<div style='float: left; margin:10px; border: 5px solid black; width: 100px; height: 400px; position: relative; bottom: 0px; text-align: center;'>
			$fill
		</div>
		";
	}
}

class Tea implements Implementer{
	public function getWater(){
		return
		"
		<div style='height: 80%; width:100%; position: absolute; bottom: 0; background-color: #d96d3b'></div>
		";
	}
	
	public function getShell($fill){
		return
		"
		<div style='float: left; margin:10px; border: 5px solid black; border-top: 0px; width: 100px; height: 150px; position: relative; bottom: 0px; text-align: center;'>
			$fill
		</div>
		";
	}
}


$drink_cola = new Drink(new Cola());
echo $drink_cola->get();

$drink_tea = new Drink(new Tea());
echo $drink_tea->get();

?>