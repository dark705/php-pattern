<?php
//Патерн формирует объектно ориентированное представление граматики для заданного автоматного языка
//Можно также рассматривать  как решение часто повторяющихся но при этом изменчивых задач
//Для примера создадим свой логический язык, в котором есть строки, переменные, проверки соответствия, а также элементами булевой алгебры
//Фактически для каждого выражения создаётся свой класс, клас для переменных, клас для строк, клас для соответствия, класс для булевого "и", класс для булевого "или"
// https://habrahabr.ru/post/136371/

//Контекст, по сути хранилище по дескриптору. 
// У каждого объекта (Выражения) есть метод getKey, который возвращает дескриптор. 
// В контекст мы передаём объекты, но реально храним пару дескриптор - значение.
class Context{
	private $store;
	
	public function __construct(){
		$store = array();
	}
	
	public function set(AbstractExpression $expression, $value){
		$this->store[$expression->getKey()] = $value;
	}
	
	public function get(AbstractExpression $expression){
		return $this->store[$expression->getKey()];
	}
}

// Все выражение в примере являются терминальными, т.е. не бъются на более мелкие.
// Аналог из разговорного языка: предложение - Не терминальное выражение (NonTerminalExpression), слово - терминальное выражение (TerminalExpression)

// Абстрактное выражение, может быть строкой, переменной, соответствием, булевым и, булевым или
abstract class AbstractExpression{
	private static $count = 0; //счетчик
	protected $_key; //дискриптор объекта выражения
	protected $value; //значение объекта выражения
	
	//Если у выражения нет дискриптора, то назначаем ему дискриптор из счётчика
	public function getKey(){
		if(!isset($this->_key)){
			self::$count++;
			$this->_key = self::$count;
		}
		return $this->_key;
	}
	
	abstract public function interpret(Context $context);
}



// Выражение - Строковый Литерал, у него есть только значение
// Дескриптор вычисляется, с помощью статического счётчика из AbstractExpression
class LiteralExpression extends AbstractExpression{
	
	public function __construct($value){
		$this->value = $value;
	}
	
	//Метод сохряняет выражение в контекст
	public function interpret(Context $context){
		$context->set($this, $this->value);
	}
}

// Выражение - Переменная, у него есть имя (дескриптор) и её значение
class VariableExpression extends AbstractExpression{
	
	public function __construct($name, $value = null){
		$this->_key = $name;
		$this->value = $value;	
	}
	
	public function interpret(Context $context){
		$context->set($this, $this->value);
	}
	//Для того чтобы могли менять значение выражения переменной
	public function setValue($value){
		$this->value = $value;
	}
}

//Абстрактный класс Выражений Операций: сравнение (проверка на тождество), и, или
abstract class OperatorExpression extends AbstractExpression{
	private $l_operand;
	private $r_operand;
	
	//Операнды являются объектами (выражениями)
	public function __construct (AbstractExpression $l_operand, AbstractExpression $r_operand){
		$this->l_operand = $l_operand;
		$this->r_operand = $r_operand;
	}
	
	public function interpret(Context $context){
		//У обоих операндов (выражений) выполняем метод интерпретировать, в нашем случае сохранить в контекст
		$this->l_operand->interpret($context); 
		$this->r_operand->interpret($context); 
		
		//доИнтерпретировать(контекст, получить левый операнд, проучиит правый операнд)
		$this->doInterpret($context, $context->get($this->l_operand), $context->get($this->r_operand));
	}
	
	//до интерпретировать doInterpret() Используется паттер Шаблонный Метод
	abstract public function doInterpret(Context $context, $l_c, $r_c);
}

class EqualsExpression extends OperatorExpression{
	public function doInterpret(Context $context, $l_c, $r_c){
		$context->set($this, $l_c === $r_c); //установить выражению результат
	}
}

class AndExpression extends OperatorExpression{
	public function doInterpret(Context $context, $l_c, $r_c){
		$context->set($this, $l_c and $r_c);
	}
}

class OrExpression extends OperatorExpression{
	public function doInterpret(Context $context, $l_c, $r_c){
		$context->set($this, $l_c or $r_c);
	}
}


//---Простой прмер
//Создаём контекст
$context2 = new Context();
//Создаём выражение утверждения сравнения, выражения строкового литерала восемь и строкового литерала один
$statement2 = new EqualsExpression(new LiteralExpression('восемь'), new LiteralExpression('один'));
//интерпретируем контекст в утверждение
$statement2->interpret($context2);
//что получилось в контексте для заданного утверждения
print $context2->get($statement2) ? "Соответсвует<br><br>" : "Не соответсвует<br><br>";


//---Сложный пример 
//Создаём контекст
$context = new Context();
//Создаём Выражение - Переменная с именем input
$input_var = new VariableExpression ('input');

//Создаём новое Выражение - Булево утверждение или. Для прощения далее опущу Выражение перед каждым словом:
//(Соответсвует Переменная input Строке восемь) или  (Соответсвует Переменная input Строке 8) 
//'input == 8' или input == 'восемь'
$statement = new OrExpression (new EqualsExpression($input_var, new LiteralExpression('восемь')),new EqualsExpression($input_var, new LiteralExpression('8')));

//Массив, значения которого будут по очереди записываться в выражение переменной  input
$some_array = array('восемь', '8', '9');


foreach ($some_array as $val){
	//по очереди устанавливаем переменной input значения из массива $some_array = 
	$input_var->setValue($val);
	$statement->interpret($context); // и проверяем утверждение
	print $context->get($statement) ? "Соответсвует<br><br>" : "Не соответсвует<br><br>";
}


?>