<?php
// Паттерн описывает способ построения конечных автоматов
// Все State имеют общий интерфейс, Конкретное состояние описывается в ConcreteState, на каждое состояние по классу.
// При этом если State - абстр. класс, то в нём могут быть определены стандартные методы, тогда как ConcreteState переопределит их
// Не все методы описаные в State необходимо реализовывать в ConcreteState,(можно использовать заглушку или исключение), по скольку
// Некоторые методы лишины смысла для некоторых состояний, и в реальности не вызываются
// Текущее состояние - объект находиться в Context
// Смена состояния может производиться как в Context так и в State, либо из вне, для этого в Context есть метод ChangeState(State)

abstract class State{
	protected $context;
	protected $_count;
	// В констркутор передаём Context, для возможности менять состояние из ConcreteState
	public function __construct(Context $context){
		$this->context = $context;
		$this->_count = 0;
	}
	
	abstract public function run(); //Общий метод для взаимодействия, но реализауия этих методов разная и определена в отдельных классах
	abstract public function get();
}

class ConcreteStateCola extends State{
	public function get(){
		return
		"<div style='float: left; margin:10px; border: 5px solid black; width: 100px; height: 400px; position: relative; bottom: 0px; text-align: center;'>
		<div style='height: 80%; width:100%; position: absolute; bottom: 0; background-color: brown'></div>
		<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: red'></div>
		<div style='height: 10%; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>Cola</h4></div>
		</div>";
	}
	
	public function run(){
		$this->context->setState(Context::STATE_FANTA); //меняем контекста из состояния (Context::STATE_FANTA - просто число, полученое из константы класса)
	}
}

class ConcreteStateFanta extends State{
	public function get(){
		return
		"<div style='float: left; margin:10px; border: 5px solid black; width: 100px; height: 400px; position: relative; bottom: 0px; text-align: center;'>
		<div style='height: 80%; width:100%; position: absolute; bottom: 0; background-color: orange'></div>
		<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: green'></div>
		<div style='height: 10%; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>Fanta</h4></div>
		</div>";
	}
	
	public function run(){
		$this->context->setState(Context::STATE_COLA); //меняем контекста из состояния (Context::STATE_FANTA - просто число, полученое из константы класса)
	}
}

class Context{
	const STATE_COLA = 1;
	const STATE_FANTA = 2;
	
	
	private $_count;
	private $state;
	//Задаем начальное состояние
	public function __construct(){
		$this->setState(Context::STATE_COLA);
		$this->_count = 1;
	}
	
	//Даём возможность менять состояния из вне
	public function setState($state_num){
		switch($state_num){ //в принципе можно было сделать $this->state = State $state, и передавать сюда объект, но это не очень хорошо, 
							// в State были бы конструкции вида $this->context->ChangeState(new ConcreteStateCola($this->context));
			case self::STATE_COLA:
				$this->state = new ConcreteStateCola($this);
				break;
			case self::STATE_FANTA:
				$this->state = new ConcreteStateFanta($this);
				break;
		}
	}
	
	public function ret(){ //таких методов может быть множество
		return $this->state->get();
	}
	
	public function request(){ //таких методов может быть множество
		if ($this->_count <= 3)
			$this->state->run();
		else 
			$this->setState(Context::STATE_COLA); //меняем состояние контекста из контекста
		$this->_count++;
	}
}

$i = 0;
$context = new Context();
while ($i <= 6){
	echo $context->ret(); //$context->get() - каждый раз обращается к объектам разных классов
	$context->request(); // могут вызываться совершенно разные методы сдесь request() это что-то вроде синхро импульса из вне
	$i++;
}

?>