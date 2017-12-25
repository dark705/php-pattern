<?php
// Предоставляет интерфейс по созданию объекта, но оставляет право подклассам изменять тип создаваемых объектов.
// В современном варианте Предоставляет интерфейс (статичный создающий метод) по созданию объекта
// Основные участники это Абстрактный продукт, и конкретные продукты которыйе является его наследниками
// Это наследование отличает паттерн от SimpleFactory


abstract class AbstractProductDrink{
	// фабричный метод который на основе типа возвращает объект
	public static function Create($product){ //Статичный он потому что инстанцировать класс рази создания объекта лишино смысла (зхачем создавать объект ради создания объекта)
		return new $product;
	}
	
	abstract public function get($size);
}

class ConcreteProductColaDrink extends AbstractProductDrink{
	public function get($size){ 
		return
		"
		<div style='float: left; margin:10px; border: 5px solid black; width: 100px; height: $size; position: relative; bottom: 0px; text-align: center;'>
			<div style='height: 85%; width:100%; position: absolute; bottom: 0; background-color: brown'></div>
			<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: red'></div>
			<div style='height: 10%; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>Colla</h4></div>
		</div>
		";
		}
}

class ConcreteProductFantaDrink extends AbstractProductDrink{
	public function get($size){
		return
		"
		<div style='float: left; margin:10px; border: 5px solid black; width: 100px; height: $size; position: relative; bottom: 0px; text-align: center;'>
			<div style='height: 85%; width:100%; position: absolute; bottom: 0; background-color: orange'></div>
			<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: green'></div>
			<div style='height: 10%; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>Fanta</h4></div>
		</div>
		";
		}
}


$cola = AbstractProductDrink::Create('ConcreteProductColaDrink'); //Это объект-продукт!
echo $cola->get('500px'); 
echo $cola->get('250px');

$fanta =  AbstractProductDrink::Create('ConcreteProductFantaDrink');  //Это объект-продукт !
echo $fanta->get('500px');


?>