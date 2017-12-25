<?
abstract class Device {
	private $staus;
	
	public function __construct(){
		$this->status = 'off';
	}
	
	public function showStaus(){
		echo $this->status;
	}
	
	public function setStatus($status){
		$this->status = $status;
	}
	
	public function getStatus(){
		return $this->status;
	}
}

trait Singleton {
	private static $instance = null;
	
	public static function getInstance(){
		if (static::$instance === null)
			static::$instance = new static();
		return static::$instance;
	}
	
	private function __construct(){}
	private function __wakeup(){}
	private function __clone(){}
}

class Lamp extends Device {
}

class Motor extends Device {
}

class Facade {
	use Singleton;
	
	private $lamp;
	private $motor;
	
	public function setSystems(Lamp $lamp, Motor $motor){
		$this->lamp =  $lamp;
		$this->motor =  $motor;
	}
	
	public function showStatusAll(){
		echo get_class($this->lamp).' is ';
		$this->lamp->showStaus();
		echo '<br>'.PHP_EOL;
		echo get_class($this->motor).' is ';
		$this->motor->showStaus();
		echo '<br>'.PHP_EOL;
	}
}

$lamp = new Lamp();
$motor = new Motor();
$facede =Facade::getInstance();
$facede->setSystems($lamp, $motor);
$facede->showStatusAll();
$motor->setStatus('On');
$facede->showStatusAll();
?>