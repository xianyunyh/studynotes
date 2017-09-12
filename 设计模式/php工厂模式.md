## 工厂模式。

使用工厂模式创建对象。根据不同的参数去创建不同的对象。

比如在一个框架中。你需要链接mysql mssql oracle。但是你需要创建这些类的实例。但是这个类都有相似的操作。比如链接、关闭、查询等。

	//抽象类
	interface Db{

		public function connect();
		public function query();
		public function close();
	}
	/**
	* 生产类的工厂 根据不同的参数。创造不同的工厂
	*/
	class Factory 
	{
		public function getInstance($type)
		{
			switch ($type) {
				case 'mysql':
					$db = new Mysql();
					break;
				case 'mssql':
					$db = new Mssql();
					break;
				case 'oracel':
					$db = new Oracel();
					break;
				default:
					# code...
					break;
			}
			return $db;
		}
		
	}
	/**
	* 每个类要实现的方法。可以拓展
	*/
	class Mysql implements Db
	{
		public function connect(){}
		public function query(){}
		public function close(){}
		
	}
	class Mssql implements Db
	{
		public function connect(){}
		public function query(){}
		public function close(){}
		
	}
	class Oracle implements Db
	{
		public function connect(){}
		public function query(){}
		public function close(){}
		
	}