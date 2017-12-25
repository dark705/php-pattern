<?php
// Паттерн организует цепочку - объектов правил (спецификаций), связанных булевой логикой, по котороым проходиться кондидат 
// Основные участники 
// Кондидат - некоторая сущьность, реализуемая в классе, которая будет проверяться на удовлетворение правилам
// Специцикация - правило реализуемое в отдельном классе, внуторь которого помещяется кондидат. Сколько правил столько и классов
// В каждой спецификации есть метод IsSatisfiedBy() возвращающий true или false в зависимости от того удовлетворяет кодидат этому правилу или нет.
// В булевой алгербре есть основные правила And, Or, Not, по этому они тоже описаны отдельным правилом в отдельных классах

interface ISpecification{
	public function _And(ISpecification $more);
	public function _Or(ISpecification $more);
	public function _Not();
	public function IsSatisfiedBy(Condidate $condidate);
}

abstract class CompositeSpecification implements ISpecification{
	private $one;
	private $two;
	// _And _Or _Not нужны для выстраивания цепочек из методов
	public function _And(ISpecification $more){
		return new AndSpecification($this, $more);
	}
	public function _Or(ISpecification $more){
		return new OrSpecification($this, $more);
	}
	public function _Not(){
		return new NotSpecification($this);
	}
	
	public abstract function IsSatisfiedBy(Condidate $condidate);
}

class AndSpecification extends CompositeSpecification{
	public function __construct (ISpecification $one, ISpecification $two){
		$this->one = $one;
		$this->two = $two;
	}
	
	public function IsSatisfiedBy(Condidate $condidate){
		return $this->one->IsSatisfiedBy($condidate) and $this->two->IsSatisfiedBy($condidate);
	}
}

class OrSpecification extends CompositeSpecification{
	public function __construct (ISpecification $one, ISpecification $two){
		$this->one = $one;
		$this->two = $two;
	}
	
	public function IsSatisfiedBy(Condidate $condidate){
		return $this->one->IsSatisfiedBy($condidate) or $this->two->IsSatisfiedBy($condidate);
	}
}

class NotSpecification extends CompositeSpecification{
	public function __construct (ISpecification $one){
		$this->one = $one;
	}
	
	public function IsSatisfiedBy(Condidate $condidate){
		return !$this->one->IsSatisfiedBy($condidate);
	}
}

//Само кастомное правило на сравнение с колой
class CompareColaSpecification extends CompositeSpecification{
	public function IsSatisfiedBy(Condidate $condidate){
		if ($condidate->getName() == 'Cola')
			return true;
		else
			return false;
	}
}

//Само кастомное правило на сравнение с фантой
class CompareFantaSpecification extends CompositeSpecification{
	public function IsSatisfiedBy(Condidate $condidate){
		if ($condidate->getName() == 'Fanta')
			return true;
		else
			return false;
	}
}


//Некоторая сущьность, которая будет проверяться на удовлетворение спецификациям
class Condidate{
	private $name;
	
	public function __construct($name){
		$this->name = $name;
	}
	
	public function getName(){
		return $this->name;
	}
}

// Создадим кондидатов, которые будут проверять правила
$condidate_cola = new Condidate('Cola');
$condidate_fanta = new Condidate('Fanta');

// Создадим правила
$rule_compare_cola = new CompareColaSpecification();
$rule_compare_fanta = new CompareFantaSpecification();

echo '<pre>';
// Выполним проверку правила на разных кондидатах
echo (int)$rule_compare_cola->IsSatisfiedBy($condidate_cola)."\n"; // true
echo (int)$rule_compare_cola->IsSatisfiedBy($condidate_fanta)."\n"; // false

// Более сложное, составное правило
echo (int)(new OrSpecification($rule_compare_cola, $rule_compare_fanta))->IsSatisfiedBy($condidate_cola)."\n"; // true ПроверитьНаКолу или ПроверитьНаФанту - Колу
echo (int)(new OrSpecification($rule_compare_cola, $rule_compare_fanta))->IsSatisfiedBy($condidate_fanta)."\n"; // true ПроверитьНаКолу или ПроверитьНаФанту - Фанту

// По скольку в CompositeSpecification описаны методы _And _Not _Or можем писать цепочки вида:
echo (int)(new CompareColaSpecification())->_Or(new CompareFantaSpecification())->IsSatisfiedBy($condidate_cola)."\n";// true
//Сфомировали новое правило - СравнитьКола или СравнитьФанта от Кола

echo (int)(new NotSpecification(new CompareColaSpecification()))->_Or(new CompareFantaSpecification())->IsSatisfiedBy($condidate_cola)."\n";// false

// Фактически мы создали сложное составное правило(цепочку спецификаций) по которым пройдёт кондидат



?>