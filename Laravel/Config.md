## Laravel Config的使用

> 配置文件存放在app\config目录下，


	use Illuminate\Support\Facades\Config;


	Config::get('app.timezone') //读取配置 app.php下的timezone的信息 
	
	Config::set('app.timezone','PRC');//设置