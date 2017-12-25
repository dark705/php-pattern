<?php

//Без паттерна легковес
class SimpleDrink{
	public static $count = 0;
	private $name;
	private $color;
	
	public function __construct($name, $color, $angle){
		self::$count++;
		$this->name = $name;
		$this->color = $color;
		$this->angle = $angle;
	}
	
	
	public function get(){
		return
		"<div style='transform: rotate($this->angle)'>
			<div style='float: left; margin:10px; border: 5px solid black; width: 100px; height: 400px; position: relative; bottom: 0px; text-align: center;'>
			<div style='height: 80%; width:100%; position: absolute; bottom: 0; background-color: $this->color'></div>
			<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: green'></div>
			<div style='height: 10%; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>$this->name</h4></div>
			</div>
		</div>";
	}
}


//Client
$ob1 = new SimpleDrink('Cola', 'Brown', '-15deg');
echo $ob1->get(); echo "ConcreteFlyweightDrink: " . SimpleDrink::$count . ", SimpleDrink: " . SimpleDrink::$count;
$ob2 = new SimpleDrink('Cola', 'Brown', '-10deg');
echo $ob2->get(); echo "ConcreteFlyweightDrink: " . SimpleDrink::$count . ", SimpleDrink: " . SimpleDrink::$count;
$ob3 = new SimpleDrink('Fanta', 'Orange', '-10deg');
echo $ob3->get(); echo "ConcreteFlyweightDrink: " . SimpleDrink::$count . ", SimpleDrink: " . SimpleDrink::$count;
$ob4 = new SimpleDrink('Fanta', 'Orange', '-3deg');
echo $ob4->get(); echo "ConcreteFlyweightDrink: " . SimpleDrink::$count . ", SimpleDrink: " . SimpleDrink::$count;
//Всего сделали 4 объекта


//Отладка
for ($i = 1; $i <= 10000; $i++){
	$o = 'ob'.$i;
	$$o = new SimpleDrink('Cola', 'Brown', '-10deg');
}