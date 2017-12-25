<?php
//Патерн  предоставляет посредника для взаимодействия отдельных объектов коллег.
// Основная логика при этом зашивается в посредника (Mediator)

interface IMediator{
	public function notify($con, Colleague $colleague);
}

class ConcreteMediator implements IMediator{
	public function setOutput($out){
		$this->out = $out;
	}
	
	//логика взаимодействия коллег
	public function notify($con, Colleague $colleague){//принять сообщение от коллеги 
		$this->out->show($con); // и переслать его другому коллеги (ConcreteColleagueShow->Show(контекст от ConcreteColleagueColla))
	}
}

//Каждый из коллег комплектуется медиатором
abstract class Colleague{
	public function __construct($mediator){
		$this->mediator = $mediator;
		
	}
}

class ConcreteColleagueColla extends Colleague{
	public function get(){//вызывается из вне клиентом, служит для отправки данных из класса
		$colla = 
		"<div style='float: left; margin:10px; border: 5px solid black; width: 100px; height: 400px; position: relative; bottom: 0px; text-align: center;'>
			<div style='height: 80%; width:100%; position: absolute; bottom: 0; background-color: brown'></div>
			<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: red'></div>
			<div style='height: 10%; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>Cola</h4></div>
		</div>";
		$this->mediator->notify($colla, $this);//отправить уведомление медиатору
	}
	
}

class ConcreteColleagueShow extends Colleague{
	public function show($str){ //вызывается медиатором, и служит для приёма
		echo $str;
	}
	
}


$mediator = new ConcreteMediator();//Создаём посредника
$colleague_cola = new ConcreteColleagueColla($mediator); //создаём коллегу1 - напиток кола, передавая в него сведенья о посреднике
$colleague_show = new ConcreteColleagueShow($mediator); //создаём коллегу2 - кто будет показывать воду. (в данном примере информация о посреднике излишна, и нужна для двухсторонних связей)
$mediator->setOutput($colleague_show); //передаём посреднику сведенья о коллеги 2 (ConcreteColleagueShow)
//запускаем прцесс на коллеги 1 из вне.
$colleague_cola->get();
//при этом выстраивается сл. цепочка:
//коллега1-метод->посредник->метод->коллега2->метод
//ConcreteColleagueColla->get()->ConcreteMediator->notify()->ConcreteColleagueShow->Show()



?>