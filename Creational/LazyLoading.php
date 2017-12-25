<?php
// Отложенная (ленивая) инициализация - Паттерн предоставляет полноценный объект только  
// когда некоторая ресурсоёмкая операция (создание объекта, вычисление значения) выполняется непосредственно перед тем, как будет использован её результат.
// Проще говоря делать предварительные или ресурсоёмкие действия только в тот момент когда они затребованы.

/*Существует несколько подходов:
    Lazy Initialization – Инициализация по требованию. Это самый простой способ – реализовать проверку поля на null и в случае необходимости заполнять его данными.
    Virtual Proxy – Виртуальный прокси-объект, вместо реального  до инициализации, выступают заменители.
    Ghost – Фиктивный объект, Призрак. Это реальный объект с неполным состоянием.
    Value Holder – Диспетчер значения. 
*/
// Lazy initialization
class LazyInitialization{
	public $fill;
	
	public function get(){
		if ($this->fill === null){//это может быть внешним классом
			$this->fill = "
			<div style='float: left; margin:10px; border: 5px solid black; width: 100px; height: 400px; position: relative; bottom: 0px; text-align: center;'>
				<div style='height: 80%; width:100%; position: absolute; bottom: 0; background-color: brown'></div>
				<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: red'></div>
				<div style='height: 10%; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>Colla</h4></div>
			</div>
			";
		}
		return $this->fill;
	}
}
$botle = new LazyInitialization();
echo (int)$botle->fill; //до первого обращения объект не полностью инициализирован
echo $botle->get();
echo "<div style='clear: both;'></div>";


// Virtual Proxy
class RealDrink{
	public function get(){
		return
		"
		<div style='float: left; margin:10px; border: 5px solid black; width: 100px; height: 400px; position: relative; bottom: 0px; text-align: center;'>
			<div style='height: 80%; width:100%; position: absolute; bottom: 0; background-color: brown'></div>
			<div style='height: 30px; width:100%; position: absolute; top: 0; background-color: red'></div>
			<div style='height: 10%; width:100%; position: absolute; top: 30%; border-top: 2px dotted black; border-bottom: 2px dotted black;'><h4>Colla</h4></div>
		</div>
		";
	}
}
class VirtualProxyDrink extends RealDrink{
	public $real_obj; //public только для демонстрации
	
	public function get(){ //создание реального объекта происходит только в момент обращения
		if ($this->real_obj === null){
			$this->real_obj = new parent; //В принципе могли не заноследоваться, а создать объект нужного класса
		}
		return $this->real_obj->get();
	}
}

$botle = new VirtualProxyDrink();
echo (int)is_object($botle->real_obj); //0 - до первого обращения объект не полностью инициализирован
echo $botle->get();
echo (int)is_object($botle->real_obj); //1 - объект инициализирован 
echo $botle->get();

?>