<?php
// NullObject, заменяет отсутствие объекта нулевым, с темже интерфейсом что и настоящий, который как правило ничего не делает
// Это позволяет избежать постоянных проверок на сущестсование объектов вроде is_null($obj);
// На примере SimpleFactory

class SimpleFactory{
	public static function create($product){
		if (class_exists($product))
			return new $product;
		else
			return new NullObject();
	}	
}

interface Drink{
	public function get();
}


class Cola implements Drink{
	public function get(){
		return
		"
		<div style='float: left; margin:10px; border: 5px solid black; width: 100px; height: 300px; position: relative; bottom: 0px; text-align: center;'>
			<div style='height: 80%; width:100%; position: absolute; bottom: 0; background-color: brown'></div>
			<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: red'></div>
			<div style='height: 10%; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>Colla</h4></div>
		</div>
		";
		}
}

class Fanta implements Drink{
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

class NullObject implements Drink{
	public function get(){
		return
		"No available";
		}
}


$cola = SimpleFactory::Create('Cola');
echo $cola->get();
$fanta =  SimpleFactory::Create('Fanta');
echo $fanta->get();
$hamburger =  SimpleFactory::Create('Hamburger');
echo $hamburger->get();

?>