<?php
//Отделяет абстрацию от реализации.
//Методы в реализацияъ должны иметь один интерфейс
abstract class Abstraction{
	protected $implementer;
	
	public function __construct ($implementer){
		$this->implementer = new $implementer;
	}
	
	public function Line(){
		return $this->implementer->drawLine();
	}
	public function Text($text){
		return $this->implementer->drawText($text);
	}
	
	public abstract function show($text);
}

class View extends Abstraction{
	public function show($text){
		echo $this->Line();
		echo $this->Text($text);
		echo $this->Line();
	}
}


interface Implementation{
	public function drawText($text);
	public function drawLine();
	//public function getResult();
}

class ImplementationHTML implements Implementation{
	public function drawText($text){
		return "<p>$text</p>" . PHP_EOL;
	}
	public function drawLine(){
		return "<hr>" . PHP_EOL;
	}
}

class ImplementationCLI implements Implementation{
	public function drawText($text){
		return $text . PHP_EOL;
	}
	public function drawLine(){
		return str_repeat('-', 80) . PHP_EOL;
	}
}

$html = new View(new ImplementationHTML);
$cli = new View(new ImplementationCLI);

$html->show('Some text here');
$cli->show('Some text here');

?>