<?php
//Паттерн предоставляет отдельный объект итератор для доступа и обхода эллементов коллекции агрегатора.
//Коллекция - массив, список, дерево, и т.д.

//Основные методы итератора - первыйЭлемент, следующийЭлемент, текущийЭлемент, естьЛиЕщеЭлементы.
//однако могут быть и другие, напр - удалить, отсортировать, предидущиэлемент, и др.
//Основное, что надо понять это, что клиент имеет доступ только к методам итератора, а не к коллекции агрегатора непосредственно
interface IIterator{
	public function _first();
	public function _next();
	public function _currient();
	public function _isdone();
}

//В интерфейсе агрегатора обязательно должен быть метод создания конкретного итератора
interface IAggregate{
	public function CreateIterator();
}

class ConcreteAggregate implements IAggregate{
	private $items;
	
	public function __construct($items){
		$this->items = $items;// В качестве коллекции будет выступать массив
	}
	
	
	public function CreateIterator(){
		return new ConcreteIterator($this->items);//В итератор мы передаём данные, в нашем примере массив.
		/*
			Хотя можно передать и сам наш объект агрегатор,
			return new ConcreteIterator($this);
			но тогда надо будет делать доп. метод получения данных коллекции
				public function getItems(){
					return $this->items;
				}
		*/
	}
}


class ConcreteIterator implements IIterator{
	private $position;
	private $items;
	
	public function __construct($item){
		$this->items = $item; //в случае передачи непосредственно объекта агрегатора, сдесь $this->items->getItems();
		$this->position = 0;
	}
	
	public function _first(){
		$this->position = 0;
		return $this->items[$this->position];
	}
	
	public function _isdone(){
		if (($this->position >= count($this->items)) or (count($this->items) == 0))
			return true;
		else
			return false;
	}
	
	public function _currient(){
		if (!$this->_isdone()) //если не закончили
			return $this->items[$this->position];
	}
	
	public function _next(){
		if (!$this->_isdone()){//если не закончили
			//$item = $this->items[$this->position];
			//$this->position++;
			//return $item; //аналогично
			return $this->items[$this->position++];
		}
	}
}

$con_agg = new ConcreteAggregate(array ('Moscow', 'Rome', 'London'));//создаём агрегатора, внутри него есть коллекция, в простейшем случае массив
$con_iter = $con_agg->CreateIterator();//запрашиваем у него объект итератор, с которым и будем в дальнейшем работать

while (!$con_iter->_isdone()){
	echo $con_iter->_next()."<br>\n";
}

?>