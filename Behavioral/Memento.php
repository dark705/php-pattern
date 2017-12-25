<?php
//Паттерн - предоставляет объект для хранения состояния
//три оновных участника
//Originator - Хозяин - тот у кого меняется состояние
//Memento - Хранитель - хранит полный набор параметров состояния хозяина
//Caretaker - Смотрящий - хранит в себе объект Memento

// Хозяин
class OriginatorDrink{
	private $params;
	
	public function __construct(){
		$params = array();
	}
	
	public function setParams($name, $color, $cap){
		 $this->params['name'] =  $name;
		 $this->params['color'] =  $color;
		 $this->params['cap'] =  $cap;
	}
	
	
	public function getDrink(){
		return
		"<div style='float: left; margin:10px; border: 5px solid black; width: 100px; height: 400px; position: relative; bottom: 0px; text-align: center;'>
		<div style='height: 80%; width:100%; position: absolute; bottom: 0; background-color: ".$this->params['color']."'></div>
		<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: ".$this->params['cap']."'></div>
		<div style='height: 10%; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>".$this->params['name']."</h4></div>
		</div>";
	}
		
	//сохранить состояние, помещая свойства необходимые для инициализации в объект Memento
	public function createMemento(){
		return new Memento($this->params); // для каждого состояния создаётся свой объект хранитель
	}
	//восстановить состояние
	public function loadMemento($memento){
		$this->params = $memento->getState();
	}
}

// Хранитель, реализует широкий интерфейс, храня в себе весь набор параметров необходимых для описания состояния хозяина
class Memento{
	private $state;
	
	public function __construct($state){
		$this->state = $state;
	}
	
	public function getState(){
		return $this->state;
	}
}

//Смотрящий, реализует тонкий интерфейс, и служит только для хранения объектов Memento, и в принципе может вызвать Memento->getState() тем самым получив доступ к набору свойств Хозяина
//Хранилище снимков (Хранителей)
class Caretaker{
	private $memento;
	
	public function setMemento(Memento $memento){
		$this->memento = $memento;
	}
	
	public function getMemento(){
		return $this->memento;
	}
}


$originator = new OriginatorDrink(); //создаём хозяина
$originator->setParams('Cola', 'brown', 'red');//устанавливаем его состояние, хотя состояние может устанавливаться и другим способом, например он сам может запросить его
echo $originator->getDrink(); //показать текущее состояние

$caretaker = new Caretaker(); //создаём смотрящего
$caretaker->setMemento($originator->CreateMemento());//передаём Смотрящему запрошенному у хозяина - хранителя, который несёт в себе данные о состоянии хозяина

$originator->setParams('fanta', 'orange', 'green');//меняем состояние хозяина
echo $originator->getDrink();//показать текущее состояние

$originator->loadMemento($caretaker->getMemento()); //восстанавливаем  состояние хозяина, передав ему хранителя запрошенного у смотрящего 
echo $originator->getDrink();//показать текущее состояние

?>