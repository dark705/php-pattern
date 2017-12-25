<?php
//Патерн строит деревья. При этом обращение к группе (составному объекту) и к конкретному объекту происходит через одинаковый интерфейс
abstract class Component{
	protected $name;
	public function __construct($name){
		$this->name = $name;
	}
	abstract function add(Component $c);
	abstract function remove($name);
	abstract function getChild($name);
	abstract function show();
}
//Составной объект
class Composite extends Component{
	private $children = array();
	
	//добавляем объект в ассоциативный массив по имени. Связка array ($name) = obj;
	public function add(Component $c){
		$this->children[$c->name] = $c;
	}
	
	//а удалять будем по имени
	public function remove($name){
		if (array_key_exists($name, $this->children)){
			unset($this->children[$name]);
			return true;
		}
		else 
			return false;
	}
	
	public function getChild($name){
		return $this->children[$name];
	}
	
	public function show(){
		$i = 0;
		foreach($this->children as $key => $child){
			$i++;
			echo "<br>";
			echo $this->name ."($i of " .count($this->children) ."): ";
			$child->show();
		}
	}
}
//Конечный объект
class Leaf extends Component{
	public function add(Component $c){
		echo 'Error add Leaf';
	}
	
	public function remove($name){
		echo 'Error remove Leaf';
	}
	
	public function getChild($name){
		echo 'Error getChild Leaf';
	}
	
	public function show(){
		echo $this->name;
	}
}


// Доюавляем корень, фактически тот же составной объект
$root = new Composite("root");

//Добавляем конечные объекты
$root->add(new Leaf("Leaf A"));
$root->add(new Leaf("Leaf B"));

//Создаём новый составной объект
$comp = new Composite("Composite X");

//В этот объект добавляем конечные объекты
$comp->add(new Leaf("Leaf XA"));
$comp->add(new Leaf("Leaf XB"));

//В корень, добавляем составной обхект
$root->add($comp);
$root->add(new Leaf("Leaf C"));

$root->show();
echo '<hr>';


$leaf = new Leaf("Leaf D");
$root->add($leaf);
$root->show();
echo '<hr>';

//Удаляем конечный объект
$root->remove("Leaf D");
$root->show();
echo '<hr>';

//Удаляем составной объект
$root->remove("Composite X");
$root->show();
echo '<hr>';

