<?php
//Текучий интерфейс
// Паттерн Организует клас при котором методы возвращают текущий объект(чаще всего) дополняя его.
// Реализованная цепочка методов (Method Chaining) при этом похожа на естественный язык


class Drink{
	private $color;
	private $name;
	private $cap;
	
	public function setColor($color){
		$this->color = $color;
		return $this;
	}
	
	public function setName($name){
		$this->name = $name;
		return $this;
	}
	public function setCap($cap){
		$this->cap = $cap;
		return $this;
	}
	
	public function get(){
		return
		"<div style='float: left; margin:10px; border: 5px solid black; width: 100px; height: 400px; position: relative; bottom: 0px; text-align: center;'>
			<div style='height: 80%; width:100%; position: absolute; bottom: 0; background-color: $this->color'></div>
			<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: $this->cap'></div>
			<div style='height: 10%; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>$this->name</h4></div>
		</div>";
	}
	//Просто для справки, не имеет отношения к паттерну:
	//__toString() - магический метод, вызывается при попытке преобразовать объект в строку
	public function __toString(){
		$str = '<br>Color: '. $this->color;
		$str .= '<br>Name: '. $this->name;
		$str .= '<br>Cap: '. $this->cap;
		return $str;
	}
}

$drink = new Drink();
$drink->setName('Cola')->setColor('Brown')->setCap('red');
echo $drink->get();
echo $drink;

?>