<?php
//Паттерн - предоставляет объект для хранения состояния
//три оновных участника
//Originator - Хозяин - тот у кого меняется состояние
//Memento - Хранитель - хранит полный набор параметров состояния хозяина
//Caretaker - Смотрящий - хранит в себе объект Memento

//В отличие от первого примера, Caretaker не имеет никакого доступа к состояниям Хранителя, Memento->getState() метода нет
//Caretaker обладает возможностью лишь восстановить состояние «Хранителя», вызвав Restore.


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
		
	//Также метод создать объект - состояние
	public function createMemento(){
		return new Memento($this, $this->params); //передаём в него себя самого и параметры для инициализации
	}
	
	//Восстановлением состояния занимается Memento
}

// Хранитель, принимает хозяина, и его параметры
class Memento{
	private $state;
	
	public function __construct($originator, $state){
		$this->originator = $originator;
		$this->state = $state;
	}
	//Фактически объект хозяина нужен только как указатель, кому будем восстанавливать состояние (кого и чем будем инициализировать)
	public function loadOriginator(){
		$this->originator->setParams($this->state['name'], $this->state['color'], $this->state['cap']); //Исходному передаём параметры
	}
}

//Смотрящий, реализует тонкий интерфейс, и служит только для хранения объектов Memento, не имея при этом непосредственного доступа к состоянию хозяина
//Хранилище снимков (Хранителей)
class Caretaker{
	private $memento;
	
	public function setMemento(Memento $memento){
		$this->memento = $memento;
	}
	
	public function getMemento(){
		return $this->memento;
	}
	//Можно сделать и так
	public function loadMemento(){
		return $this->memento->loadOriginator();
	}
}


$originator = new OriginatorDrink(); //создаём хозяина
$originator->setParams('Cola', 'brown', 'red');//устанавливаем его состояние, хотя состояние может устанавливаться и другим способом, например он сам может запросить его
echo $originator->getDrink(); //показать текущее состояние

$caretaker = new Caretaker(); //создаём смотрящего
$caretaker->setMemento($originator->CreateMemento());//передаём Смотрящему запрошенному у хозяина - хранителя, который несёт в себе данные о состоянии хозяина

$originator->setParams('fanta', 'orange', 'green');//меняем состояние хозяина
echo $originator->getDrink();//показать текущее состояние

$caretaker->getMemento()->loadOriginator();//Запрашиваем Смотрящего, объект с состоянием, и говорим восстановить хозяина.
echo $originator->getDrink();//показать текущее состояние

//Можно сделать и так
$caretaker->loadMemento();//Вызываем у Смотрящего восстановление (сдесь нужны аргументы, поскольку Caretaker хранит множество Memento)
echo $originator->getDrink();//показать текущее состояние

?>