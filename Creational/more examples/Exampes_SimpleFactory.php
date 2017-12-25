<?php
class SimpleFactory{
	private function __construct(){}
	private function __clone(){}
	private function __wakeup(){}
	
	public static function create($product){
		switch ($product){
			case 'ProductA':
				return new ProductA();
			case 'ProductB':
				return new ProductB();
			default:
				return new ProductNull ();
				//throw new Exception ("There is no product $product");
		}
	}
}

class Product {
	public function ShowName(){
		echo $this->name."<br>\n";
	}
}

class ProductA extends Product{
	public function __construct(){
		$this->name = 'This is Product A';
	}
}

class ProductB extends Product{
	public function __construct(){
		$this->name = 'This is Product B';
	}
}

class ProductNull extends Product{
	public function __construct(){
		$this->name = 'There is no product';
	}
}

$pr1 = SimpleFactory::Create('ProductA');
$pr2 = SimpleFactory::Create('ProductB');
$pr3 = SimpleFactory::Create('ProductC');

$pr1->ShowName();
$pr2->ShowName();
$pr3->ShowName();
?>