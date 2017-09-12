## 单例模式

单例模式的特点。类只有一个实例，常在数据库的实例，缓存，日志等实例使用。

单例模式实现很简单，依靠静态属性和静态方法的特点。

	class Single 
	{
		private static $_instance;//
		private function __construct()
		{
			return false;
		}
	
		private function __clone()
		{
			return false;
		}
		/**
		 * 产生单例的外部接口
		 */
		public function getInstance()
		{
			
			if(self::$_instance instanceof self){
				return self::$_instance;
			}
			self::$_instance = new self();
			return self::$_instance;
		}
	
	}