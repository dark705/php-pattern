<?php
// Патерн  описывает способы подмены алгоритмов
// Конкретный алгоритм при этом выносится из контекста Context в отдельны класс ConcreteStrategy,
// Все стратегии имеют единый интерфейс. Контекст конфигурируется КонкретнойСтратегией, выбор которой ложится на клиента
// Действие одно но при этом разная реализация.

interface Strategy{
	public function get();
}

class Context {
	private $strategy;
	
	public function __construct(Strategy $strategy){
		$this->strategy = $strategy;
	}
	
	public function DoIt(){
		return $this->strategy->get();
	}
	
	public function setStrategy(Strategy $strategy){
		$this->strategy = $strategy;
	}
}

class ConcreteStrategyA implements Strategy{
	public function get(){
		$water = "<div style='height: 80%; width:100%; position: absolute; bottom: 0; background-color: brown'></div>";
		$cap = "<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: red'></div>";
		$label = "<div style='height: 10%; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>Cola</h4></div>";
		$botle_start = "<div style='float: left; margin:10px; border: 5px solid black; width: 100px; height: 400px; position: relative; bottom: 0px; text-align: center;'>";
		$botle_end = "</div>";
		return $botle_start.$water.$cap.$label.$botle_end; // разная реализация
	}
}

class ConcreteStrategyB implements Strategy{
	public function get(){
		$water = "<div style='height: 80%; width:100%; position: absolute; bottom: 0; background-color: brown'></div>";
		$cap = "<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: red'></div>";
		$label = "<div style='height: 10%; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>Cola</h4></div>";
		$botle = "<div style='float: left; margin:10px; border: 5px solid black; width: 100px; height: 400px; position: relative; bottom: 0px; text-align: center;'>".$water.$cap.$label."</div>";
		return $botle; // разная реализация
	}
}

$context_st_a = new Context(new ConcreteStrategyA());
$context_st_b = new Context(new ConcreteStrategyB());
echo $context_st_a->DoIt();
echo $context_st_b->DoIt();
// Либо так
$context_st_a->setStrategy(new ConcreteStrategyB());
$cola1 =  $context_st_a->DoIt();
$context_st_a->setStrategy(new ConcreteStrategyA());
$cola2 =  $context_st_a->DoIt();

echo (bool)($cola1 == $cola2);

?>