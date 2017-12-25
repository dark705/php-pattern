<?php
// Паттерн предназначен для централизованного создания продуктов объектов как правило схожего типа
// Как правило статичный создающий метод включается большой условный оператор, возвращающий разные объекты, в т.ч. различных классов, в зависимости от аргумента
// Статичный он потому, что инстанцировать класс ради создания объекта (которым и будем оперировать) лишино смысла (зачем создавать объект ради создания объекта)
// У SimpleFactory обычно нет подклассов

class SimpleFactory{
	public static function create($product){
		switch($product){
			case 'Cola':
				return new Cola();
			case 'Fanta':
				return new Fanta();
		}
	}
}

class Cola{
	public function get(){
		return
		"
		<div style='float: left; margin:10px; border: 5px solid black; width: 100px; height: 400px; position: relative; bottom: 0px; text-align: center;'>
			<div style='height: 80%; width:100%; position: absolute; bottom: 0; background-color: brown'></div>
			<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: red'></div>
			<div style='height: 10%; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>Colla</h4></div>
		</div>
		";
		}
}

class Fanta {
	public function get(){
		return
		"
		<div style='float: left; margin:10px; border: 5px solid black; width: 100px; height: 400; position: relative; bottom: 0px; text-align: center;'>
			<div style='height: 85%; width:100%; position: absolute; bottom: 0; background-color: orange'></div>
			<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: green'></div>
			<div style='height: 10%; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>Fanta</h4></div>
		</div>
		";
		}
}


$cola = SimpleFactory::create('Cola'); // $cola это объект!
echo $cola->get();
$fanta = SimpleFactory::create('Fanta');
echo $fanta->get();




?>