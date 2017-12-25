<?php
// Патерн  формирует структуру алгоритмов
abstract class Drink{
	
	//Определяет высокоуровневый алгоритм (скелет), состоящий из последовательности действий, определённых или переопределённых в классах наследниках 
	// Наследники не меняют  шаблонный метод!
	public final function TemplateMethod1(){
		$in = $this->GetWater().$this->GetCap().$this->GetLabel();
		return  $this->GetBottle($in);
	}
	// Важно заметить что таких алгоритмов может быть несколько, TemplateMethodX(), 
	// а сама последовательность действий может быть не линейной, а представлять сложный алгоритм. 

	abstract protected function GetWater();
	abstract protected function GetCap();
	abstract protected function GetLabel();
	
	//часть методов может быть описана в базовом классе, наслидники могут переопределить или дополнить его.
	protected function GetBottle($in){
		return "<div style='float: left; margin:10px; border: 5px solid black; width: 100px; height: 400px; position: relative; bottom: 0px; text-align: center;'>".$in."</div>";
	}	
}

//КонкретнаяРеализация шагов Кола
class Cola extends Drink{
	protected function GetWater(){
		return "<div style='height: 80%; width:100%; position: absolute; bottom: 0; background-color: brown'></div>";
	}
	
	protected function GetCap(){
		return "<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: red'></div>";
	}
	
	protected function GetLabel(){
		return "<div style='height: 10%; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>Cola</h4></div>";
	}
}


//КонкретнаяРеализация шагов Фанта
class Fanta extends Drink{
	protected function GetWater(){
		return "<div style='height: 80%; width:100%; position: absolute; bottom: 0; background-color: orange'></div>";
	}
	
	protected function GetCap(){
		return "<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: green'></div>";
	}
	
	protected function GetLabel(){
		return "<div style='height: 10%; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>Fanta</h4></div>";
	}
}


$cola = new Cola();
echo $cola->TemplateMethod1();

$fanta = new Fanta();
echo $fanta->TemplateMethod1();
?>