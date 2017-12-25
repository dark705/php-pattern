<?php
//Патерн организует СВЯЗЬ между доментом (т.е. объектом в широком смысле) и постоянным хранилищем (например БД, или XML файл)
//В Маппер выносится вся логика взаимодействия с постоянным хранилищем (получение, сохранение, удаление, поиск)

//Домен
class Drink{
	protected $angle;
	
	public function get(){
		return
		"<div style='transform: rotate($this->angle)'>
			<div style='float: left; margin:10px; border: 5px solid black; width: 100px; height: 400px; position: relative; bottom: 0px; text-align: center;'>
			<div style='height: 80%; width:100%; position: absolute; bottom: 0; background-color: brown'></div>
			<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: green'></div>
			<div style='height: 10%; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>Cola</h4></div>
			</div>
		</div>";
	}
	
	public function getState(){ //Есть некоторый метод получения состояния
		return $this->angle;
	}
	
	public function setState($angle){
		$this->angle = $angle;
	}
	
}
//Маппер, работает с определённым видом хранилища (Storage) и определённым видом домена(Drink)
class DrinkMapper{
	private $storage;
	
	// Маппер комплектуется хранилищем
	public function __construct(Storage $storage){
		$this->storage = $storage; 
		//Реализовывать сдесь авто загрузку состояния объекта  не правильно, поскольку тогда
		//__construct($storage, $obj) привяжет нас к определённому объекту, и для каждого объекта нам потребуется отдельный маппер
		//Лучше иметь один маппер привязанный к хранилищу, но работающий с группой объектов
		
	}
	
	//В загрузчик передаётся объект состояние которого мы восстанавливаем, либо инициализируем
	public function load(Drink $obj){
		$obj->setState($this->storage->data);
	}
	
	//В маппер передаётся объект - домен
	public function save(Drink $obj){
		$this->storage->data = $obj->getState(); //А он сохряняет из него только состояния которые в будующем позволят инициализировать искомый объект
	}
}
//Постоянное хранилище, в примере просто поле класса Storage, в реальности SQL, XML и т.д.
class Storage{
	public $data;
}


$storage = new Storage();
$storage->data = '-20deg'; // в постоянном хранилище была информация необходимая для инициализации объекта
$mapper = new DrinkMapper($storage);
$obj = new Drink();

$mapper->load($obj); //инициализируем объект
echo $obj->get();

$obj->setState('-10deg'); // поработали с объектом, он изменил своё состояние
echo $obj->get();
$mapper->save($obj); //Можем его сохранить
echo $storage->data 
?>