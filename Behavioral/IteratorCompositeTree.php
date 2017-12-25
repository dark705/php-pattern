<?php
//Патерн строит деревья. При этом обращение к группе и к конкретному объекту происходит через одинаковый интерфейс
abstract class Component{
	protected $name;
	public function __construct($name){
		$this->name = $name;
	}
	abstract function Add(Component $c);
	abstract function Remove($name);
	abstract function GetChild($name);
	abstract function GetData();
	
	public function CreateIterator(){
		return new ConcreteIterator($this);
	}
	
	public function GetName(){
		return $this->name;
	}
}

class Composite extends Component{
	private $tree = array();
	
	//добавляем объект в ассоциативный массив по имени. Связка array ($name) = obj;
	public function Add(Component $c){
		$this->tree[$c->name] = $c;
	}
	
	//а удалять будем по имени
	public function Remove($name){
		if (array_key_exists($name, $this->tree)){
			unset($this->tree[$name]);
			return true;
		}
		else 
			return false;
	}
	
	public function GetChild($name){
		return $this->tree[$name];
	}
	
	
	public function GetData(){
		return $this->tree;
	}
}

class Leaf extends Component{
	public function Add(Component $c){
		echo 'Error Add Leaf';
	}
	
	public function Remove($name){
		echo 'Error Remove Leaf';
	}
	
	public function GetChild($name){
		echo 'Error GetChild Leaf';
	}
	
	
	public function GetData(){
		return $this;
	}
}



class ConcreteIterator{
	private $obj;
	private $tree;
	
	public function __construct($obj){
		$this->arr = $this->_tree_to_array($obj);
	}
	
	
	public function _next(){
		if (!$this->_isDone()){
			$cur = current($this->arr);
			next($this->arr);
			return $cur;
		}
	}
	
	public function _first(){
		return reset($this->arr);
	}
	
	public function _current(){
		return current($this->arr);
	}
	
	public function _isDone(){
		if (current($this->arr) != null)
			return false;
		else
			return true;
	}
	//Преобразуем дерево в последовательный массив объектов дерева
	public function _tree_to_array($obj){
		$arr = array();
		foreach($obj->getData() as $child){
			if (is_a($child, 'Composite')){
				$arr[] = $child; //Тут зависит от задачи... Либо наш массив будет состоять только из Leaf, либо в него будет входить и Composite
				$arr = array_merge($arr, $this->_tree_to_array($child));
			}
			else
				$arr[] = $child;
		}
		return $arr;
	}
	
}


// Доюавляем корень, фактически тот же составной объект
$root = new Composite("root");

//Добавляем конечные объекты
$root->Add(new Leaf("Leaf A"));
$root->Add(new Leaf("Leaf B"));

//Создаём новый составной объект
$comp = new Composite("Composite X");

//В этот объект добавляем конечные объекты
$comp->Add(new Leaf("Leaf XA"));
$comp->Add(new Leaf("Leaf XB"));

//В корень, добавляем составной обхект
$root->Add($comp);
$root->Add(new Leaf("Leaf C"));


$iter = $root->CreateIterator();

echo $iter->_next()->GetName().'<br>';
echo $iter->_next()->GetName().'<br>';
echo $iter->_first()->GetName().' ->Вернули на начало<br>';
echo $iter->_next()->GetName().'<br>';
echo $iter->_next()->GetName().'<br>';
echo $iter->_next()->GetName().'<br>';
echo $iter->_next()->GetName().'<br>';
echo $iter->_next()->GetName().'<br>';echo (int)$iter->_isDone();
echo $iter->_next()->GetName().'<br>';echo (int)$iter->_isDone();
