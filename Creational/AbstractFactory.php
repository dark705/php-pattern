<?php
// Паттерн пораждает семейств взаимодействующих продуктов (объектов), без указания их классов
// АбстрактнаяФабрика - место где создаются продукты(объекты) определённого семейства, например СемействоКола(фабрика1) или СемействоФанта(фабрика2).
// В конкретной фабрики создаётся семейство гарантированно совместимое между собой, напр. объекты ВодаКОЛА и БутылкаКОЛА или ВодаФАНТА и БутылкаФАНТА
// АбстрактныйПродукт место где создаёются обстрактные продукты, например вода(продуктА) и бутылка(продуктБ), у класса есть соответствующий интерфейс
// В конкретном продукте создаётся конкретный продукт, например ВодаКОЛА(продуктA1) или БутылкаФАНТА(пролуктБ2)


//Абстрактная фабрика - автомат по производству породуктов(объектов) А и B (воды и бутылки для напитка)
abstract class AbstractFactoryDrink{
	protected $water;
	protected $bottle;

	public function createWater(){ //Создающий метод
		return $this->water;
	}
	public function createBottle(){ //Создающий метод
		return $this->bottle;
	}
}
//Конкретная фабрика 1 - Автомат по созданию воды колы, и бутылки колы, т.е. мы гарантируем совместимость воды и бутылки
class Cola extends AbstractFactoryDrink{
	public function __construct(){
		$this->water = new ColaWater;
		$this->bottle = new ColaBottle;
	}
}
//Конкретная фабрика 2 - Автомат по созданию воды фанты, и бутылки фанты, т.е. мы гарантируем совместимость воды и бутылки
class Fanta extends AbstractFactoryDrink{
	public function __construct(){
		$this->water = new FantaWater;
		$this->bottle = new FantaBottle;
	}
}

//Абстрактный продукт А - Вода
abstract class Water{
	protected $color;
	public function get(){
		return "<div style='height: 75%; width:100%; position: absolute; bottom: 0; background-color: $this->color'></div>";
	}
}
//Абстрактный продукт Б - Бутылка
abstract class Bottle{
	protected $name;
	public function get($water){
		return "<div style='float: left; margin:10px; border: 5px solid black; width: 100px; height: 500px; position: relative; bottom: 0px; text-align: center;'>$water $this->name</div>";
	}
}
//Конкретный продукт A1 - Кола Вода, для фабрики 1 (атомата колы)
class ColaWater extends Water{
	public function __construct(){
		$this->color = 'brown';
	}
}
//Конкретный продукт Б1 - Кола Бутылка, для фабрики 1 (атомата колы)
class ColaBottle extends Bottle{
	public function __construct(){
		$this->name = 'Cola';
	}
}

//Конкретный продукт A2 - Фанта Вода, для фабрики 2 (атомата фанты)
class FantaWater extends Water{
	public function __construct(){
		$this->color = 'orange';
	}
}

//Конкретный продукт Б2 - Фанта Бутылка, для фабрики 2 (атомата фанты)
class FantaBottle extends Bottle{
	public function __construct(){
		$this->name = 'Fanta';
	}
}


/*
Итого 
Фабрика1 делает продуктA1 и продуктБ1
Фабрика2 делает продуктA2 и продуктБ2
Возможна ситуация:
Фабрика3 делает продуктA1 и продуктБ2, но это семейство совместимо!
*/


// Создаём Фабрику1 - колу, она будет делать ВодаКОЛА и БутылкаКОЛА
$cola_factory  = new Cola();
$cola_water = $cola_factory->createWater()->get();//создаём продукт (объект) воду колу и получаем её
$cola_bottle = $cola_factory->createBottle()->get($cola_water);// создаём  продукт (объект) бутылку с надписью кола получаем её и наливаем туда воду колу, фактически сделаем сборку
//таким образом мы гарантированно имеем соаместимые части, по скольку они создаются на одной конкретной фабрике
echo $cola_bottle;

//Аналогично для Фабрики2
$fanta_factory = new Fanta();
echo $fanta_factory->createBottle()->get($fanta_factory->createWater()->get());

// Паттерн не говорит о том как собирать семейство продуктов и надоли его сообирать вообще, 
// Если надо - можем сделать сборщик
class Collector{
	
	public function get($factory){
		return $factory->createBottle()->get($factory->createWater()->get());//по скольку фабрики имеют унифицированный интерфейс унасл. от AbstractFactory
	}
}

$co = new Collector(); // создали новый объект сборщик

echo $co->get(new Cola());// передали в сборщик колу
echo $co->get(new Fanta());

// Важные замечения. 
// Мы должны абстрогироваться от процесса реализации создания того или иного продукта.
// по этому не совсем правильно передавать из конкретной фабрики те или иные параметры при создании объекта - конкретного продукта, чтобы небыло new ColaWater('brown')
// нам важно чтобы все фабрики реализовывали одинаковый интерфейс, по этому может прописать функции по реализации этих интерфейсов ещё в абстрактном классе.
// конкретные параметры мы задаём в процессе реализации того или иного продукта. 
// По сути если продукты разных фабрик координально отличаются, то можно использовать наследование от интерфейса а не от абстрактного класса
// в моём примере продукты идентичны и отличаются только цветом и названием, по этому я вынес общую логику создаия в абстрактный класс.


?>