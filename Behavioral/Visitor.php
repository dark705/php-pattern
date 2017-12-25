<?php
// Патерн  организует обход набора элементов с различными (разнородными) интерфейсами.
// Позволяет добавить новое поведение ко всем объектам некой связанной структуры, не изменяя самих объектов
// обходит связанную структуру один объект за другим, и, в зависимости от типа посещённого объекта, выполняет над ним какое-то своё действие

interface Visitor{
	//На каждый посещаемый класс - свой метод посещения, при этом в параметрах мы указыывем компонент того типа, которому соответствует принимающий метод. 
	public function VisitConcreteElementA(ConcreteElementA $element);
	public function VisitConcreteElementB(ConcreteElementB $element);
}


class ConcreteVisitor implements Visitor{
	public function VisitConcreteElementA(ConcreteElementA $element){
		return $element->GetElementA();// У элемента вызываем тот или иной метод в зависимости от класса 
	}
	
	public function VisitConcreteElementB(ConcreteElementB $element){
		return $element->GetElementB();// У элемента вызываем тот или иной метод в зависимости от класса 
	}
	
}

class ObjectStructure{
	private $elements;
	
	public function __construct(){
		$this->elements = array();
	}
	
	public function Attach(Element $element){
		$this->elements[] = $element;
	}
	
	public function Detach(Element $element){
		$i = 0;
		foreach ($this->elements as $element_s){
			if ($element_s === $element){
				unset($this->elements[$i]);
				break;
			}
			$i++;
		}
	}
	
	public function Accept(Visitor $visitor){
		foreach ($this->elements as $element){
			echo $element->Accept($visitor); // Каждый элемент по очереди получает посетителя
		}
	}
}

interface Element{
	public function Accept(Visitor $visitor); // У каждого элемента должен быть метод получения посетителя
}

class ConcreteElementA implements Element{
	// Цель этого метода — вызвать тот метод посещения, который соответствует типу компонента. 
	public function Accept(Visitor $visitor){
		return $visitor->VisitConcreteElementA($this);
	}
	
	public function GetElementA(){
		return
		"<div style='float: left; margin:10px; border: 5px solid black; width: 100px; height: 400px; position: relative; bottom: 0px; text-align: center;'>
		<div style='height: 80%; width:100%; position: absolute; bottom: 0; background-color: brown'></div>
		<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: red'></div>
		<div style='height: 10%; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>Cola</h4></div>
		</div>";
	}
}

class ConcreteElementB implements Element{
	// Цель этого метода — вызвать тот метод посещения, который соответствует типу компонента. 
	public function Accept(Visitor $visitor){
		return $visitor->VisitConcreteElementB($this);
	}
	public function GetElementB(){
		return
		"<div style='float: left; margin:10px; border: 5px solid black; width: 100px; height: 400px; position: relative; bottom: 0px; text-align: center;'>
		<div style='height: 80%; width:100%; position: absolute; bottom: 0; background-color: orange'></div>
		<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: green'></div>
		<div style='height: 10%; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>Fanta</h4></div>
		</div>";
	}
}

$obj = new ObjectStructure();// Создали некоторую структуру объектов
$obj->Attach(new ConcreteElementA()); // Добавили в структуру конеретный элемент A
$obj->Attach(new ConcreteElementB()); // Добавили в структуру конеретный элемент B
$obj->Accept(new ConcreteVisitor()); // Выполнили метод, укомплектовав его посетителем.
// Каждый элемент по очереди получает посетителя, посетитель будучи в элементе вызывает в себе специфичный метод посещения передав в него текущий посещаемый элемент,
//элемент будучи уже в посетителе вызывает специфичный для себя метод.
//-------------ObjectStructure--------------------------------------------------------|--------ConcreteElement---------------|----Visitor------------
//ObjectStructure->Accept(Visitor)->foreach(ConcreteElement):Element->Accept(Visitor)->Visitor->VisitConcreteElement...(this)->Element->someOperation

 
?>