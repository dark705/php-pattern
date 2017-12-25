<?php
//Паттерн используется для создания ряда связанных или зависимых объектов. 
//Разница между этим шаблоном и Абстрактной Фабрикой заключается в том, 
//что Статическая Фабрика использует только один создающий статический метод, 
//чтобы создать все допустимые типы объектов. Этот создающий статический метод, обычно, называется factory или build.
// Статичный он потому, что инстанцировать класс (создавать объект) ради создания другого объекта, которым и будем оперировать, лишино смысла (зачем создавать объект ради создания объекта)

//СтатичнаяФабрика - автомат по производству породуктов А и B (воды и бутылки для напитка)
abstract class Drink{
	protected function __construct(){}
	public abstract static function build($product);
}
//Конкретная фабрика 1 - Автомат по созданию воды колы, и бутылки колы, т.е. мы гарантируем совместимость воды и бутылки
class Cola extends Drink{
	
	public static function build($product){ //Статичный Создающий метод
		switch ($product){
			case 'Water':
				return new ColaWater();
			case 'Bottle':
				return new ColaBottle();
		}
	}
	
}
//Конкретная фабрика 2 - Автомат по созданию воды фанты, и бутылки фанты, т.е. мы гарантируем совместимость воды и бутылки
class Fanta extends Drink{
	public static function build($product){ //Статичный Создающий метод
		switch ($product){
			case 'Water':
				return new FantaWater();
			case 'Bottle':
				return new FantaBottle();
		}
	}	
}

//Продукт А - Вода
abstract class Water{
	protected $color;
	public function get(){
		return "<div style='height: 75%; width:100%; position: absolute; bottom: 0; background-color: $this->color'></div>";
	}
}
//Продукт Б - Бутылка
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


//Соберём семейство продуктов конкретной фабрики
$cola_water = Cola::build('Water')->get();//создаём воду колу, на фабрике Cola, и получаем её. Помним Паттерн создаёт объекты! Cola::build('Water'), а что мы с ними делаем ->get() это не столь важно
$cola_bottle = Cola::build('Bottle')->get($cola_water);// создаём  бутылку с надписью кола и наливаем туда воду колу, фактически сделаем сборку
//таким образом мы гарантированно имеем совместимые части, по скольку они создаются на одной конкретной статической фабрики
echo $cola_bottle;

//Аналогично для Фабрики2
$fanta_botle = Fanta::build('Bottle')->get(Fanta::build('Water')->get());
echo $fanta_botle;


// У нас довольно сложный пример, т.к. в метод build по мимо вида создаваемого продукта (объекта), передаются также доп параметры, в данном случае конкретная вода

// Если надо собирать, сделаем клас - Клиент по сборке
class Collector{
	public function get($factory){
			return $factory::build('Bottle')->get($factory::build('Water')->get());
	}
}

$co = new Collector(); // создали новый объект, передав ему статичную фабрику с автоматом колы
echo $co->get('Cola');// говорим что хотим осуществить сборку Колы
echo $co->get('Fanta');// говорим что хотим осуществить сборку Колы


?>