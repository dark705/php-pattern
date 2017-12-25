<?php
//Патерн  представляет запрос в виде объекта, представляет запрос объектно-ориентированно
// 3 участника Invoker - командир, Command - комманда, Receiver - получатель, исполнитель
//Invoker объекты Command передаёт для выполнения Receiver'у

interface Command{	
	public function Execute();
	public function UnExecute();
}

//Команда
class MathCommand implements Command{
	private $receiver;
	private $operator;
	private $operand;
	
	public function __construct($receiver, $operator, $operand){
		$this->receiver = $receiver;
		$this->operator = $operator;
		$this->operand = $operand;
	}
	
	public function Execute(){
		$this->receiver->operation($this->operator, $this->operand);
	}
	
	public function UnExecute(){
		$this->receiver->operation($this->undo($this->operator), $this->operand);
	}
	
	private function undo($operator){
		switch($operator){
			case '+': return '-';
			case '-': return '+';
			case '*': return '/';
			case '/': return '*';
		}
	}
}
//Получатель, тот кто обрабатывает объекты Command
class Receiver{
	public $result;
	
	public function __construct(){
		$this->result = 0;
	}
	
	public function operation($operator, $operand){
		switch($operator){
			case '+': $this->result+=$operand; break;
			case '-': $this->result-=$operand; break;
			case '*': $this->result*=$operand; break;
			case '/': $this->result/=$operand; break;
		}
	}
	
	public function getResult(){
		return  $this->result;
	}
}

//Инициатор, Командир, отправитель, дословно вызыватель.
class Invoker{
	private $commands;
	private $steps;
	
	public function __construct(){
		$this->commands = array();
		$this->steps = 0;
	}	
		
	public function setCommand($command){
		$this->commands[] = $command;
		$this->steps++;
	}
	
	public function run(){
		for ($i = 0; $i < $this->steps; $i++){
			$this->commands[$i]->Execute();
		}
	}
	
	public function undo($step = 1){
		for ($i = 1; $i <= $step; $i++){
			$this->commands[$this->steps - $i]->UnExecute();
		}
		$this->steps = $this->steps - $step;
	}
	
	public function redo($step = 1){
		for ($i = 0; $i < $step; $i++){
			$this->commands[$this->steps + $i]->Execute();
		}
		$this->steps = $this->steps + $step;
	}
}

//client
$invoker = new Invoker ();//Создаём командира
$receiver = new Receiver(); //Создаём получателя, который будет обрабатывать объекты коман
//Передаём 4 объекта команд командиру
$invoker->setCommand(new MathCommand($receiver, '+', 100)); //step 0 - 100
$invoker->setCommand(new MathCommand($receiver, '-', 50));	//step 1 - 50
$invoker->setCommand(new MathCommand($receiver, '*', 3));	//step 2 - 150
$invoker->setCommand(new MathCommand($receiver, '/', 2));	//step 3 - 75
//Все команды укомплектованы получателем(исполнителем, обработчиком)

//Выполняем все объекты команды
$invoker->run();
echo $receiver->getResult()."<br /n>"; //при этом забираем результат мы у получателя

//Отменяем 3 последние объекта команды
$invoker->undo(2);
$invoker->undo();
echo $receiver->getResult()."<br /n>";
//Повторяем 2 последние команды
$invoker->redo(2);
echo $receiver->getResult()."<br /n>";

?>