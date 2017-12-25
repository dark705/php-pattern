<?php
//Патерн организует взаимодействие домена и постоянном хранилища (например БД, или XML файл)

//Домен, с возможностью хранения состояния в постоянном хранилище
class Drink{
	private $angle;
	
	// Косплектуем домен постоянным хранилищем
	public function __construct($storage){ 
		$this->storage = $storage;
		if ($this->angle === null)
			$this->load(); //Можем реализовать авто загрузку состояния при инициализации
	}

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
	
	//Метод инициализирует состояние домена (объекта) из постоянного хранилища
	public function load(){
		$this->angle = $this->storage->data;
	}
	//Сохряняет свойства необходимые для инициализации в постоянном хранилище.
	public function save(){
		$this->storage->data = $this->angle; //А он сохряняет из него только состояния которые в будующем позволят инициализировать искомый объект, домен
	}
	
}

//Постоянное хранилище
class Storage{
	public $data;
}


$storage = new Storage();
$storage->data = '-20deg'; // в постоянном хранилище была информация необходимая для инициализации объекта
$obj = new Drink($storage);
//$obj->load(); //инициализируем объект, нет необходимости, начальная инициализация происходит в конструкторе домена
echo $obj->get();

$obj->setState('-10deg'); // поработали с объектом, он изменил своё состояние
echo $obj->get();
$obj->save(); //Можем его сохранить
echo 'Value in storage:'.$storage->data

?>