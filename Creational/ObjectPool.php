<?php
// Паттерн предоставляет набор готовых объектов
// Его целесообразно использовать когда требуется много времени на создание нового многократно используемого объекта, 
// и его проще держать в некотором хранилище - пуле, чем создавать а потом унчтожать


//Продукт описывает некоторый многократно используемый объект, например бутылку
class Bottle{
	private $num; //порядковый номер объекта
	
	public function __construct($num){
		$this->num = $num;
	}
	
	public function get(){
		return
		"
		<div style='float: left; margin:10px; border: 5px solid black; width: 100px; height: 400px; position: relative; bottom: 0px; text-align: center;'>
			<div style='height: 80%; width:100%; position: absolute; bottom: 0; background-color: brown'></div>
			<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: red'></div>
			<div style='height: 10%; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>Colla</h4></div>
			$this->num
		</div>
		";
	}
}

// Хранилище описывает, хранилище объектов, например бутылок
class BottlePool{
	private $_count;
	private $free_obj;
	private $busy_obj;
	
	public function __construct(){
		$this->free_obj = array();
		$this->busy_obj = array();
		$this->_count = 0;
	}
	
	//получение оъекта
	public function get(){
		//Реализую стратегию - Расширение пула.
		//если свободных объектов нет
		if (count($this->free_obj) === 0)
			$obj = new Bottle($this->_count++); //создаю новый
		else
			$obj = array_pop($this->free_obj); //если есть то выдёргиваю из свободных
		//$this->busy_obj[spl_object_hash($obj)] = $obj; //перенашу объект в список занятых
		$this->busy_obj[spl_object_hash($obj)] = true;//Надоли хранить исходныйобъект в списке занятых? Объект храниться 2 раза - в пуле и в контексте
		return $obj;
	}
	
	//возвращение объекта
	public function release($obj){
		//проверка на существования такого объекта
		$key_obj = spl_object_hash($obj); //Если объект был изменён у него не сойдётся хеш
		if (array_key_exists($key_obj, $this->busy_obj)){
			unset($this->busy_obj[$key_obj]);
			$this->free_obj[] = $obj;
			return true;
		}
		return false;
	}

	// суммарное число объектов, занятых и свободных
	public function obj_total(){
		return ($this->obj_free() + $this->obj_busy());
	}
	public function obj_free(){
		return count($this->free_obj);
	}
	public function obj_busy(){
		return count($this->busy_obj);
	}
	
	
}
//Создаю новый пул
$botle_pool = new BottlePool();
$botte1 = $botle_pool->get(); //Получаю объект 1
$botte2 = $botle_pool->get(); //Получаю объект 2

echo $botte1->get();
echo $botte2->get();
echo "<div style='clear: both;'></div>";
echo 'Занято объектов:' . $botle_pool->obj_busy() . "<br> \n";
echo 'Свободно объектов:' . $botle_pool->obj_free() . "<br> \n";
echo "<div style='clear: both;'></div>";

//Возвращаю объекты в пул
echo "Возвращаем объекты в пул<br> \n";
$botle_pool->release($botte1);
unset($botte1);
$botle_pool->release($botte2);
unset ($botte2);
echo 'Занято объектов:' . $botle_pool->obj_busy() . "<br> \n";
echo 'Свободно объектов:' . $botle_pool->obj_free() . "<br> \n";

//Используем повторно, при этом мы не тратим время на инициализацию, на создание объектов класса Bottle, мы просто возвращаем их из пула
echo "Повторно использую объект из пула не тратя время на инициализацию<br> \n";
$botte1 = $botle_pool->get();
echo $botte1->get();
echo 'Занято объектов:' . $botle_pool->obj_busy() . "<br> \n";
echo 'Свободно объектов:' . $botle_pool->obj_free() ."<br> \n";


?>