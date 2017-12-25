<?php
// Паттерн описывает пошаговое построение сложных продуктов (объектов)
// Участники: 
// Директор - говорит выполнить последовательность действий на строителе в определённом порядке (таких последовательностей - методов может быть несколько)
// Строитель - выполняет действия, необходимые для полноценного создания объекта, и возвращает готовый результат продукт - объект
// Продукт - базовый объект, который необходимо "приготовить", т.е. выполнить над ним ряд действий, 
// Продукты могут иметь различный интерфейс (интерффейс строителей одинаков!),
// важно лишь чтобы конкретный строитель знал интерфейс конкретного продукта, который он "готовит"

//Продукт
class Drink{
	private $water;
	private $cap;
	private $label;
	private $res;
	
	public function setWater($color){
		$this->water = "<div style='height: 85%; width:100%; position: absolute; bottom: 0; background-color: $color'></div>";
	}
	
	public function setCap($color){
		$this->cap = "<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: $color'></div>";
	}
	
	public function setLabel($name){
		$this->label = "<div style='height: 10%; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>$name</h4></div>";
	}
	
	public function combine(){
		$this->res = "<div style='float: left; margin:10px; border: 5px solid black; width: 100px; height: 500px; position: relative; bottom: 0px; text-align: center;'>$this->water $this->cap $this->label</div>";
	}
	
	public function get(){
		return $this->res;
	}
	
	
}
//Абстрактный Строиетель, определяет шаги, но не последовательность выполнения
abstract class BuilderDrink{
	protected $drink;
	
	public function __construct(){
		$this->drink = new Drink();
	}
	
	abstract public function buildWater();
	abstract public function buildCap();
	abstract public function buildLabel();
	
	public function combine(){
		$this->drink->combine();
	}
	//Продукт возвращает строитель
	public function getResult(){
		return $this->drink;
	}
	
}
//Конкретный строиетель передаёт продукту необходимые параметры
//Определяет реализацию конкретных шагов строительства, но не их последовательность!
class ColaBuilder extends BuilderDrink{
	
	public function buildWater(){
		$this->drink->setWater('brown');
	}
	public function buildCap(){
		$this->drink->setCap('red');
	}
	public function buildLabel(){
		$this->drink->setLabel('CocaColla');
	}
	
}
//Ещё один конкретный строитель
class FantaBuilder extends BuilderDrink{

	public function buildWater(){
		$this->drink->setWater('orange');
	}
	public function buildCap(){
		$this->drink->setCap('green');
	}
	public function buildLabel(){
		$this->drink->setLabel('Fanta');
	}
}

// Директор(вариант1) вызывает шаги строительства на строителе в определённой последовательности.
// При этом он работает с конкретным строителем, строитель может быть передан разными методами, например при вызове метода сборки
class Direktor{
	// Таких методов может быть несколько, в зависимости от того что хотим создать
	public function create($builder){
		// Также последовательность действий сожет быть не линейна и включать условные операторы
		$builder->buildWater();
		$builder->buildCap();
		$builder->buildLabel();
		$builder->combine();
	}
}


$director = new Direktor();// создаём директора
$builder1 = new ColaBuilder();// создаём конкретного строителя
$director->create($builder1);//Даём команду директору чтоб тот вызвал определённую последовательность действий по созданию объекта в строителе
$product1 = $builder1->getResult(); //получить объект у строителя!, а не у директора. лишняя пересылка через директора не нужна
echo $product1->get();			//кроме того интерфейсы различных ПРОДУКТОВ могут отличаться (интерфейс строителя одинаков)
//один директор может работать с разными строителями, и правильнее чтобы результат хранил не директор а именно строитель
// Ещё раз, строитель возвращает именно объект(продукт), как и все параждающие паттерны. Что делать с этим объектом потом другой вопрос
 

$director->create($builder2 = new FantaBuilder());
echo  $builder2->getResult()->get(); // Получаем объект - продукт у строителя, после чего вытаскиваем из объекта интересующие данный и выводим на экран

//Директор(вариант2)
//Хотя существуют вариации когда, директор комплектуется строителя, но при этом мы теряем возможность менять строителя на лету, (хотя можно как в в /* */)
class Direktor_n{
	private $builder;
	public function __construct($builder){
		$this->builder = $builder;
	}
	/* 
	public function setBuilder($builder){
		$this->builder = $builder;
	}
	*/
	public function create(){
		$this->builder->buildWater();
		$this->builder->buildCap();
		$this->builder->buildLabel();
		$this->builder->combine();
	}
}

$director_n = new Direktor_n($builder_n = new ColaBuilder());
$director_n->create();
echo $builder_n->getResult()->get();


//Директор(вариант3)
//некоторые источники designpatternsphp предлагают делать так, но тут идёт пересылка продукта через директора, что не есть хорошо.
class Direktor_dp{
	private $builder;
	public function __construct($builder){
		$this->builder = $builder;
	}

	public function create(){
		$this->builder->buildWater();
		$this->builder->buildCap();
		$this->builder->buildLabel();
		$this->builder->combine();
		return $this->builder->getResult();
	}
}

echo (new Direktor_dp(new FantaBuilder()))->create()->get();


//В общем источники расходятся в методе реализации директора, важно лишь что он всегда отдаёт посдедовательно команды по реализации конечного продукта
?>