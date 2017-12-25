<?php
//Абстракция
abstract class Abstraction{
	protected $implementer;
	
	public function __construct($implementer){
		$this->implementer = $implementer;
	}
	
	protected function get(){
		return $this->implementer->getColor();
	}
}
//Refined abstraction - очищенная абстракция, в ней нет отсылов на реализацию, а используется только родительский класс
class Circle extends Abstraction{
	public function show(){
		echo '<div style="margin:5px; border:1px solid black; border-radius: 50%; width:70px; height:70px; overflow:hidden; text-align:center;">'.$this->get().'</div>';
	}
}

class Square extends Abstraction{
	public function show(){
		echo '<div style="margin:5px; border:1px solid black; width:70px; height:70px; overflow:hidden; text-align:center;">'.$this->get().'</div>';
	}
}

//Реализация, в данном случае это просто цвет
abstract class Realisation{
	protected $color;
	public function getColor(){
		return $this->color;
	}
}

class Red extends Realisation{
	public function __construct(){
		$this->color = '<div style="width:100%; height:100%; background-color:red;"></div>';
	}
}

class Blue extends Realisation{
	public function __construct(){
		$this->color = '<div style="width:100%; height:100%; background-color:blue;"></div>';
	}
}
class Green extends Realisation{
	public function __construct(){
		$this->color = '<div style="width:100%; height:100%; background-color:green;"></div>';
	}
}

//В итоге имеем 6 разных объектов, которые пораждены 5-тью классами 2 абстракции и 3 реализации
(new Circle(new Red))->show();
(new Circle(new Blue))->show();
(new Square(new Red))->show();
(new Square(new Blue))->show();
(new Circle(new Green))->show();
(new Square(new Green))->show();

?>
