<?php
//Патерн  создаёт цепочку из обработчиков запросов.
//Абстрактный обработчик
abstract class Handler{
	protected $check;
	protected $_next;
	
	protected static $chain = 1; //исключительно для подсчёта номера обработчика в цепотчке
	
	public function __construct($next = null){
		$this->_next = $next;
	}
	
	//Если можешь обработать обработай сам и верни результат
	//Если не можешь - передай сл. в цепи и верни результат
	public function HandleRequest($drink){//сюда можно передать как объект так и например строку. 
		if ($this->check() == $drink)		//условие возможности обработки, например у объекта можно вызвать метод
			return $this->get().static::$chain;//исключительно для подсчёта номера обработчика в цепотчке
		elseif ($this->_next != null){ //Если не можем и есть сл. в цепочки, передаём ему запрос и получаем от него результат
			static::$chain++;//исключительно для подсчёта номера обработчика в цепотчке
			return $this->_next->HandleRequest($drink);
		}
		//здесь может быть терминатор, если не один из обработчиков не обработал запрос
	}
	
	abstract public function get();
}


//Конкретный обработчик
class ConcreteHandlerCola extends Handler{
	public function check(){
		return 'cola';
	}
	
	public function get(){
		return
		"<div style='float: left; margin:10px; border: 5px solid black; width: 100px; height: 400px; position: relative; bottom: 0px; text-align: center;'>
			<div style='height: 80%; width:100%; position: absolute; bottom: 0; background-color: brown'></div>
			<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: red'></div>
			<div style='height: 10%; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>Cola</h4></div>
		</div>";
	}
}

//Конкретный обработчик
class ConcreteHandlerFanta extends Handler{
	public function check(){
		return 'cola';
	}
	
	public function get(){
		return
		"<div style='float: left; margin:10px; border: 5px solid black; width: 100px; height: 400px; position: relative; bottom: 0px; text-align: center;'>
			<div style='height: 80%; width:100%; position: absolute; bottom: 0; background-color: orange'></div>
			<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: green'></div>
			<div style='height: 10%; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>Fanta</h4></div>
		</div>";
	}
}

//Конкретный обработчик
class ConcreteHandlerSoda extends Handler{
	public function check(){
		return 'soda';
	}
	
	public function get(){
		return
		"<div style='float: left; margin:10px; border: 5px solid black; width: 100px; height: 400px; position: relative; bottom: 0px; text-align: center;'>
			<div style='height: 80%; width:100%; position: absolute; bottom: 0; background-color: white'></div>
			<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: black'></div>
			<div style='height: 10%; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>Soda</h4></div>
		</div>";
	}
}

//выстраивам цепочку
//$chain = new ConcreteHandlerCola(new ConcreteHandlerFanta(new ConcreteHandlerSoda()));

//Последовательность цепочки определяет клиент, внешние сущности или фабрики, цепочка может выстраиваться динамически
$chain = new ConcreteHandlerCola(new ConcreteHandlerSoda(new ConcreteHandlerFanta()));
//Каждая цепь является объектом

echo $chain->HandleRequest('soda'); //В качестве аргумента могли передать объект

?>