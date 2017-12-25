<?php
// Патерн  процесс предоставления внешней зависимости программному компоненту.
// Проще говоря класс не запрашивает сам что-то из вне (например параметры или объекты), а получает их (например через конструктор или сеттер).
// В этом случае нам не нужно будет менять сам код класса, а можно изменить передаваемые классу данные.

//Искомый класс который зависисит от параметров 
class Drink{
	private $color;
	private $name;
	private $cap;
	private $angle;
	//вариация приёма параметров через конструктор, хотя могли передавать и черз сеттер
	public function __construct(Params $params){
		$this->color = $params->getColor();
		$this->name = $params->getName();
		$this->cap = $params->getCap();
		$this->angle = $params->getAngle();
	}
	
	public function get(){
		return
		"<div style='transform: rotate($this->angle)'>
			<div style='float: left; margin:10px; border: 5px solid black; width: 100px; height: 400px; position: relative; bottom: 0px; text-align: center;'>
			<div style='height: 80%; width:100%; position: absolute; bottom: 0; background-color: $this->color'></div>
			<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: $this->cap'></div>
			<div style='height: 10%; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>$this->name</h4></div>
			</div>
		</div>";
	}
}

//Зависимость в виде класса конфигуратора
class Params {
	private $color;
	private $name;
	private $cap;
	private $angle;
	
	public function __construct($color, $name, $cap, $angle){
		$this->color = $color;
		$this->name = $name;
		$this->cap = $cap;
		$this->angle = $angle;
	}
	
	public function getColor(){
		return $this->color;
	}
	public function getName(){
		return $this->name;
	}
	public function	getCap(){
		return $this->cap;
	}
	public function	getAngle(){
		return $this->angle;
	}
}
$params1 = new Params('brown', 'Cola', 'red', '-15deg');
$params2 = new Params('orange', 'Fanta', 'green', '-5deg');

$cola = new Drink($params1);
$fanta = new Drink($params2);

echo $cola->get();
echo $fanta->get();

?>