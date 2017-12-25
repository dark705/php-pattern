<?php
// Паттер реализует событийную модель, издатедатель(наблюдаемый) - подписчик (наблюдатель)
// При изменении состояния издателя (Subject) - оповещает всех зарегистрированных у себя подписчиков
// Существуют 2 модели Pull и Push
// Pull - Издатель лишь говорит что есть изменения, а подписчик сам запрашивает состояние у издателя
// Push - Издатель отправляет изменеие подписчику на прямую

// Push Pull модель, что-то среднее, издатель (наблюдаемый) передаёт ссылку на собственный объекьт, а что с этим делать решает наблюдатель
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
	// Удаление из списка
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
	//Уведомление всех подписчиков об изменившемся состоянии издателя (наблюдаемого), передавая ссылку на собственный объекьт
	public function Notify(){
		foreach ($this->observers as $observer){
			$observer->update($this); //отличие от Pull Push
		}
	}
	//Устанавливаем состояние издателя, устанавливаем событие
	public function setState($state){
		$this->state = $state;
		$this->Notify();//при установки состояния, информируем всех;
	}
	//отличие от Pull
	public function getState(){
		return $this->state;
	}
}

class ConcreteSubject extends Subject{
}

abstract class Observer{
	//protected $subject;
	protected $state;
	/*//отличие от Pull
	public function __construct($subject){
		$this->subject = $subject;
	}
	*/
	
	public function update($subject){
		$this->state = $subject->getState();
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
//Создаём наблюдателей
$observer1 = new ConcreteObserver1();
$observer2 = new ConcreteObserver2();
$observer3 = new ConcreteObserver3();
//Добавляем в список издателя наблюдателей;
$subject->Attach($observer1);
$subject->Attach($observer2);
$subject->Attach($observer3);
//Сдесь также двусторонняя связь, наблюдаемый посылает ссылку на себя в метод наблюдателя, а тот уже запрашивает у наблюдателя состояние или нет

$subject->setState('On');
$subject->Detach($observer2);
$subject->setState('Off');


?>