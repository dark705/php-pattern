<?php
//Динамически (в ходе выполнения) добавляет обьектам новую функциональность
//Декаратор и компонент имеют одинаковые интерфейсы! Однако декаратор дополняет действия методов компонента.


interface IComponent{
	public function Get();
}

//Компонент
class ConcreteComponent implements IComponent{
	public function Get(){
		return "
		<div style='float: left; margin:10px; border: 5px solid black; width: 100px; height: 400px; position: relative; bottom: 0px; text-align: center;'>
		<div style='height: 80%; width:100%; position: absolute; bottom: 0; background-color: brown'></div>
		<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: red'></div>
		<div style='height: 10%; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>Colla</h4></div>
		</div>
		";
	}
}

//Декоратор
abstract class Decorator implements IComponent{
	protected $component;
	
	public function __construct($component){
		$this->component = $component;
	}
}
//Конкретный декоратор, реализует конкретную доп функциональность
class ConcreteDecoratorA extends Decorator{
	public function Get(){
		// Поведение метода дополнилось
		return str_replace('Colla', 'Colla lite spec', $this->component->Get());
	}
	
}

class ConcreteDecoratorB extends Decorator{
	public function Get(){
		// Поведение метода дополнилось
		return $this->transform($this->component) ;
	}
	//дополнительное действие не изменило интерфейс
	private function transform($ob){
		return "<div style='transform: rotate(-15deg)'>".$ob->Get()."</div>";
	}
	
}


//Получаем объект конкретного - базового компонента
$cola = new ConcreteComponent();
echo $cola->Get();

//Динамически добавляем объекту новую функциональность А
$cola = new ConcreteDecoratorA($cola); //При этом имеем новый объект с новой функциональностью но тем же интерфейсом.
echo $cola->Get();

//Динамически добавляем объекту новую функциональность B
$cola = new ConcreteDecoratorB($cola);
echo $cola->Get();

//Можно вкладывать одну обёртку в другую, по скольку они имеют один и тот же интерфейс, и клиенту всё равно с чем работать.
$cola_tra = new ConcreteDecoratorB(new ConcreteDecoratorA(new ConcreteComponent()));
echo $cola_tra->Get();


?>
