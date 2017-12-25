<?php
class Director{
	public function CreateHome($builder){
		$builder->SetFooter();
		$builder->SetBody();
		$builder->SetHeader();
	}
	
	public function CreateBigHome($builder){
		$builder->SetFooter();
		$builder->SetBody();
		$builder->SetBody();
		$builder->SetBody();
		$builder->SetHeader();
	}
}

//Абстрактный строитель, все строители имеют унифицированный интерфейс
abstract class Builder{
	public function __construct(){
		$this->home = new Home();
	}
	
	public function GetResult(){
		return $this->home;
	}
	abstract public function SetFooter();
	abstract public function SetBody();
	abstract public function SetHeader();
}

//Строитель 1
class WoodBuilder extends Builder{
	public function SetFooter(){
		$this->home->SetPart('Деревянный пол');
	}
	public function SetBody(){
		$this->home->SetPart('Деревянные стены');
	}
	public function SetHeader(){
		$this->home->SetPart('Деревянная крыша');
	}
}

//Строитель 2
class StoneBuilder extends Builder{
	public function SetFooter(){
		$this->home->SetPart('Каменный пол');
	}
	public function SetBody(){
		$this->home->SetPart('Каменные стены');
	}
	public function SetHeader(){
		$this->home->SetPart('Каменная крыша');
	}
}
//Продукт, в данном случае представлен одним классом
class Home{
	private $result;
	
	public function __construct(){
		$this->result = '';
	}
	
	public function SetPart($part){
		$this->result .= $part;
	}
	
	public function Show(){
		echo $this->result."<br>\n";
	}
}

$director = new Director();
$director->CreateHome($wood_builder = new WoodBuilder()); //Директор даёт команды строителю
$director->CreateBigHome($stone_builder = new StoneBuilder());

$wood_builder->GetResult()->Show(); //Результат забираем у строителя
$stone_builder->GetResult()->Show();
?>