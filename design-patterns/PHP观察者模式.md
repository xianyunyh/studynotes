## 观察者模式

观察者模式定义了一系列对象之间的一对多关系，当一个对象改变状态后，其他依赖者都会收到通知。

观察者模式这种发布-订阅的形式我们可以拿微信公众号来举例，假设微信用户就是观察者，微信公众号是被观察者，有多个的微信用户关注了程序猿这个公众号，当这个公众号更新时就会通知这些订阅的微信用户
![](http://img.blog.csdn.net/20160301173208772)
重要角色：

抽象通知者角色（INotifier）：定义了通知的接口规则。
具体通知者角色（Boss）：实现抽象通知者的接口，接到状态改变立即向观察者下发通知。
抽象观察者角色（IObserver）：定义接到通知后所做的操作（Update）接口规则。
具体观察者角色（JingDong）：实现具体操作方法。

	//定义通知者的接口
	interface Subject {
    /**
     * 增加订阅者
     * @param observer
     */
    public function attach($observer);
    /**
     * 删除订阅者
     * @param observer
     */
    public function detach($observer);
    /**
     * 通知订阅者更新消息
     */
    public function notify($message);

	}

		class SubjectClass implements Subject
	{
		public $subjects = [];
		public function attach($observer){
			if(!in_array($observer,$this->subjects)){
				$this->subjects[] = $observer;
			}
		}
		public function detach($observer){
			$key = array_search($observer, $this->subjects);
			if(in_array($observer,$this->subjects)){
				unset($this->subjects[$key]);
			}
		}
		public function notify(){
			foreach($this->subjects as $subject){
				$subject->update($this);
			}
	
		}
	
	}
	
	interface Observer {
		public function update();
	}
	
	//具体的订阅者
	class Observer1 implements Observer
	{
		public function update(){
	
		}
	}
	//具体的订阅者
	class Observer2 implements Observer
	{
		public function update(){
			
		}
	}
	$subject  = new SubjectClass();
	$observer1 = new Observer1();
	$observer2 = new Observer2();
	$subject->attach($observer1);
	$subject->attach($observer2);