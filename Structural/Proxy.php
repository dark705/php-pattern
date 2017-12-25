<?php
//Предоставляет объект заместитель.
//Является сурогатом другого объекта и контролирует доступ к нему.

interface Drink{
	public function Get($angle);
}

//Реальный объект
class RealDrink implements Drink{
	public function Get($angle){
		return
		"<div style='transform: rotate($angle)'>
			<div style='float: left; margin:10px; border: 5px solid black; width: 100px; height: 400px; position: relative; bottom: 0px; text-align: center;'>
			<div style='height: 80%; width:100%; position: absolute; bottom: 0; background-color: brown'></div>
			<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: green'></div>
			<div style='height: 10%; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>Cola</h4></div>
			</div>
		</div>";
	}
}

//Прокси, имеет тот же интерфейс
class ProxyDrink implements Drink{ 
//Лучше реализовывать интерфейс чем наследоваться от родителя, поскольку наследоваться не всегда возможно, и тянемм за собой код родителя
	private $r;
	
	public function __construct(){
		$this->r = new RealDrink();//Создание реального объекта происходит внутри, прокси контролирует этот процесс
		//Еслибы мы принимали объект через конструктор, этоб был бы Decorator
		// Реальный объект может быть создан в констркуторе или в любом другом методе.
	}
	
	public function Get($angle){
		//какие-то дополнительные действия, например:
			//удалённый заместитель
			//создание объекта по требованию 
			//защита
			//кеширование
			//логирование
		//например кеширование и создание по требованию:
		if ($this->r == null)
			$this->r = new RealDrink();
		//обращение к реальному объекту:
		return $this->r->Get($angle);
	}		
}


$drink = new ProxyDrink();
echo $drink->Get('-10deg');


?>

