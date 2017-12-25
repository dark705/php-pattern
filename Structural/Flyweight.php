<?php
//Патерн организует работу с разделяемыми объектами
//т.е. если у множества объектов есть совпадающие состояния, то их целесообразно представить как: общее состояние (внутр.) + уникальное состояние(внешнее)
//Общее, внутреннее состояние выносится в конструктор легковеса, а внешнее в аргументы методов

interface FliweightDrink{
	public function get($angle);
}

//В легковес целесообразно выносить данные занимаеющие много ресурсов,
//Легковесов мало, но они занимаеют много ресурсов
class ConcreteFlyweightDrink implements FliweightDrink{
	public static $count = 0;
	private $name;
	private $color;
	
	public function __construct($name, $color){
		self::$count++;
		$this->name = $name;
		$this->color = $color;
	}
	
	public function get($angle){
		return
		"<div style='transform: rotate($angle)'>
			<div style='float: left; margin:10px; border: 5px solid black; width: 100px; height: 400px; position: relative; bottom: 0px; text-align: center;'>
			<div style='height: 80%; width:100%; position: absolute; bottom: 0; background-color: $this->color'></div>
			<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: green'></div>
			<div style='height: 10%; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>$this->name</h4></div>
			</div>
		</div>";
	}
}

//фабрика леговесов, смотрит  решает когда нужно создать новый легковес, а когда можно обойтись существующим.
class FlyweightFactoryDrink {
	private static $fliweight = array();
	
	public static function GetConcreteFlyweightDrinkDrink($name, $color){
		$key = md5($name . $color);
		if (!array_key_exists($key, self::$fliweight)){
			self::$fliweight[$key] = new ConcreteFlyweightDrink($name, $color);
		}
		return self::$fliweight[$key];
	}
}

//Весь смысл паттерна сводиться к тому чтобы разделить внешнее и внутр состояние. Внутр, переносится в конструктор, внешнее в методы.
//L =  new FlyweightFactory(внутр состояние)
//L->Operation(внешнее состояние) 

//UnsharedConcreteFlyweightDrink: не рассматриваю. Это еще одна конкретная реализация интерфейса, определенного в интерфейсе Flyweight, только теперь объекты этого класса являются неразделяемыми
//К этому классу мы обращаемся на прямую а не через фабрику.
//Они используются в тех случаях, когда разделить состояние нельзя, а каждый объект этого подвида должен быть уникальным во всех контекстах.
//Благодаря общему интерфейсу, их можно использовать совместно с конкретными легковесами.



//Конкретный объект хранит в себе полный набор параметров, для создания объекта
//Их много, но они хранят в себе только ссылку на малое число легковесов
//ConcreteDrink (в принципе это тоже клиент)
class ConcreteDrink {
	private $angle;
	private $fliweight;
	public static $count = 0;
	
	
	public function __construct($name, $color, $angle){
		self::$count++;
		//Состояния которые занимали много ресурсов передаём в фабрику легковесов
		$this->fliweight = FlyweightFactoryDrink::GetConcreteFlyweightDrinkDrink($name, $color); //получаем от фабрики объект с заданными параметрами
		//а стояния которые занимали мало ресурсов, сохраняем в текущий объект
		$this->angle = $angle;
	}
	//которое будем использовать при вызове соответствующиъ методов
	public function get(){
		return $this->fliweight->get($this->angle);
	}
}

//Client
$ob1 = new ConcreteDrink('Cola', 'Brown', '-15deg');
echo $ob1->get(); echo "ConcreteFlyweightDrink: " . ConcreteFlyweightDrink::$count . ", ConcreteDrink: " . ConcreteDrink::$count;
$ob2 = new ConcreteDrink('Cola', 'Brown', '-10deg');
echo $ob2->get(); echo "ConcreteFlyweightDrink: " . ConcreteFlyweightDrink::$count . ", ConcreteDrink: " . ConcreteDrink::$count;
$ob3 = new ConcreteDrink('Fanta', 'Orange', '-10deg');
echo $ob3->get(); echo "ConcreteFlyweightDrink: " . ConcreteFlyweightDrink::$count . ", ConcreteDrink: " . ConcreteDrink::$count;
$ob4 = new ConcreteDrink('Fanta', 'Orange', '-3deg');
echo $ob4->get(); echo "ConcreteFlyweightDrink: " . ConcreteFlyweightDrink::$count . ", ConcreteDrink: " . ConcreteDrink::$count;
//Всего сделали 4 объекта, при этом 4 объекта используют всего 2 легковеса


//Отладка
for ($i = 1; $i <= 10000; $i++){
	$o = 'ob'.$i;
	$$o = new ConcreteDrink('Cola', 'Brown', '-10deg');
}