<?php
//Паттер реализует событийную модель, издатедатель(наблюдаемый) - подписчик (наблюдатель)
// При изменении состояния издателя (Subject) - оповещает всех зарегистрированных у себя подписчиков
//Существуют 2 модели Pull и Push
//Pull - Издатель лишь говорит что есть изменения, а подписчик сам запрашивает состояние у издателя
//Push - Издатель отправляет изменеие подписчику на прямую

//Pull модель (сдесь есть двухсторонняя связь), мы получаем только уведомления, а забирать состояние или нет, и когда это делать решаем сами
abstract class Subject{
	protected $observers;
	protected $state;
	public function __construct(){
		$this->observers = array();
	}
	//Регистрация наблюдателя в списке подписчиков
	public function Attach(Observer $observer){
		$this->observers[] = $observer;
	}
	//Удаление из списка
	public function  Detach (Observer $observer){
		$i = 0;
		foreach ($this->observers as $item){
			if($item == $observer){
				unset($this->observers[$i]);
				break;
			}
			$i++;
		}
	}
	//Уведомление всех подписчиков об изменившемся состоянии издателя (наблюдаемого)
	public function Notify(){
		foreach ($this->observers as $observer){
			$observer->Update();//отличие от Push
		}
	}
	//Устанавливаем состояние издателя, устанавливаем событие
	public function setState($state){
		$this->state = $state;
		$this->Notify();//при установки состояния, информируем всех;
	}
	
	public function getState(){
		return $this->state;
	}
}

class ConcreteSubject extends Subject{
}

abstract class Observer{
	protected $subject;
	protected $state;
	
	public function __construct($subject){//Наблюдатель знает о издателе
		$this->subject = $subject;
	}
	
	public function Update(){
		$this->state = $this->subject->getState();
		echo 'State was updated on '.get_class($this).' to state: '.$this->state.'<br>';
	}
}

class ConcreteObserver1 extends Observer{
}
class ConcreteObserver2 extends Observer{
}
class ConcreteObserver3 extends Observer{
}

$subject = new ConcreteSubject();
//Наблюдатель знает о издателе, чтобы иметь возможность запросить у него состояние
$observer1 = new ConcreteObserver1($subject);
$observer2 = new ConcreteObserver2($subject);
$observer3 = new ConcreteObserver3($subject);
//Добавляем в список издателя наблюдателей;
$subject->Attach($observer1);
$subject->Attach($observer2);
$subject->Attach($observer3);
//Образована двусторонняя связь
//Наблюдаемый уведомляем от измененияз, а наблюдатель сам запрашивает состояние у наблюдаемого.

$subject->setState('On');
$subject->Detach($observer2);
$subject->setState('Off');

?>