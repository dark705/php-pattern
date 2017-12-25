<?php
// Предоставляет интерфейс по созданию объекта, но оставляет право подклассам изменять тип создаваемых объектов.
// Основные участники:
// Фабрика - определяет интерфейс по созданию объекта, конкретная фабрика сама опереопределяет какой тип продукта ей создавать
// Продукт - определяет интерфейс продукта, а конкретные продукты реализуют либо дополняют его в зваисимости был это интерфейс или абстр. класс



abstract class FactoryMethod{
	protected $concreteProduct;
	
	public function FactoryMethodCreate(){
		return new $this->concreteProduct;
	}
}

class ColaFactory extends FactoryMethod{

	public function __construct(){
		$this->concreteProduct = 'ColaDrink';
	}
	/*
	можно было написать что-то вроде:
		public function FactoryMethodCreate($size){
		return new ColaDrink();
	}
	
	*/
}

class FantaFactory extends FactoryMethod{
	public function __construct(){
		$this->concreteProduct = 'FantaDrink';
	}
}


interface Drink{
	public function get($size);
}

class ColaDrink implements Drink{
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

class FantaDrink implements Drink{
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




$factory1 = new ColaFactory();  //Это объект-фабрика
$product1 = $factory1->FactoryMethodCreate();//Это объект-продукт!
echo $$product1->get('500px');
echo $$product1->get('250px');

$factory2 = new FantaFactory();
echo $factory2->FactoryMethodCreate()->get('500px');
//Конкретная фабрика переопределяя абстрактный класс выбирает какой класс продукта ей использовать

?>