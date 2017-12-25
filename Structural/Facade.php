<?php
//Предоставляет простой, высокоуровневый интерфейс для доступа к подсистеме (подклассам)

//Фасад
class FacadeWater{
	private $sub_sys1_water;
	private $sub_sys2_bottle;

	public function __construct( subSystem1Water $system1, subSystem2Bottle $system2){
		//Хороший фасад не содержит вызовов new subSystem по скольку это делает его фабрикой... $this->sub_sys1_water = new subSystem1Water();
		// а оперирует полученными подсистемами, в полной мере реализуя DependencyInjection
		$this->sub_sys1_water = $system1;
		$this->sub_sys2_bottle = $system2;
	}
	
	public function Show(){
		echo $this->Get();
	}
	
	public function Get(){
		$water = $this->sub_sys1_water->getWater();
		return $this->sub_sys2_bottle->getBottle($water);
	}

}
//Подсистема1
class SubSystem1Water{
	public $ver;
	public function __construct(){
		$this->ver = '1.0';
	}
	
	public function getWater(){
		return "<div style='height: 80%; width:100%; position: absolute; bottom: 0; background-color: brown'></div>";
	}
}
//Подсистема2
class SubSystem2Bottle{
	public $ver;
	public function __construct(){
		$this->ver = '2.1';
	}
	public function getBottle($water){
		return
		"<div style='float: left; margin:10px; border: 5px solid black; width: 100px; height: 400px; position: relative; bottom: 0px; text-align: center;'>
		$water
		<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: red'></div>
		<div style='height: 10%; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>Colla</h4></div>
		</div>";
	}
}

// Чаще всего у нас уже были подсистемы
$system1 = new SubSystem1Water();
$system2 = new SubSystem2Bottle();
// и мы уже работали с ними на прямую
echo $system1->ver."<br> \n";
echo $system2->ver."<br> \n";

//А теперь работаем через фасад
$drink = new FacadeWater($system1, $system2); // Можно конечно написать new FacadeWater(new SubSystem1Water(), new SubSystem2Bottle()), но это это немного не то
echo $drink->Get(); //Через высокоуровневый интефейс


//Часто нужен только один фасад, по этому его делают одичночкой.
?>
