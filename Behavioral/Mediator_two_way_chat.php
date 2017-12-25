<?php
//Патерн  предоставляет посредника для взаимодействия отдельных объектов коллег.
// Основная логика при этом зашивается в посредника (Mediator)

interface IMediator{
	public function notify($message, Colleague $colleague);
}

class ConcreteMediator implements IMediator{
	private $partners;
	
	public function __construct(){
		$this->partners = array();
	}
	
	//используем магический метод, для получения данных о коллагах
	public function __set($name, Colleague $colleague_obj){
		$this->partners[$name] = $colleague_obj;//$this->partners['colleague1'] = obj ConcreteColleague1
	}
	
	//реализуем алгоритм взаимодействия межу коллегами, в примере двухсторонний обмен сообщениями
	public function notify($message, Colleague $colleague){
		if ($colleague === $this->partners['colleague1']) //если сообщение пришло от коллеги1
			 $this->partners['colleague2']->show($message); //отправляем коллеги2
		else//если нет
			$this->partners['colleague1']->show($message);//отправляем коллеги1
	}
}

abstract class Colleague{
	private $mediator;
	
	//Каждый из коллег комплектуется медиатором
	public function __construct($mediator){
		$this->mediator = $mediator;
	}
	
	//вызывается из вне клиентом, служит для уведомления медиатора (в примере отправки сообщения из объекта коллеги)
	public function send($message){ 
		$this->mediator->notify($message, $this);
	}
}

class ConcreteColleague1 extends Colleague{
	//вызывается медиатором, и служит для приёма
	public function show($message){
		echo "Incoming message for colleague1: $message <br>";
	}
}

class ConcreteColleague2 extends Colleague{
	//вызывается медиатором, и служит для приёма
	public function show($message){
		echo "Incoming message for colleague2: $message <br>";
	}
}

$mediator = new ConcreteMediator(); //создаём посредника
//формируем двунаправленные отношения между коллегами и посредником 
$colleague1 = new ConcreteColleague1($mediator); //создаём коллегу1, передавая ему информацию о посреднике (коллега знает о посреднике)
$colleague2 = new ConcreteColleague2($mediator); //создаём коллегу2, передавая ему информацию о посреднике
$mediator->colleague1 = $colleague1; //передаём в посредник коллегу1 (посредник знает о коллеге)
$mediator->colleague2 = $colleague2; //передаём в посредник коллегу2 
//colleague1<->mediator<->colleague2 - двусторонние отношения сформированы

//запускаем процесс из вне на коллегах!
$colleague1->send('message from 1'); //colleague1->send(message)->mediator->notify(message, i am(this))
									 //дальше начинает отрабатывать логика медиатора реализованная в notify()->colleague2->show(message)
$colleague2->send('message from 2');

// Коллеги не знают друг о друге, и оповещают лишь посредника, который сам потом должен разобраться что с этим делать

?>