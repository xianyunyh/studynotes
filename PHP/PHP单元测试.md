## PHPunit安装

> PHPUnit 6.1 需要 PHP 7，强烈推荐使用最新版本的 PHP.代码覆盖率分析报告功能需要 Xdebug（2.5.0以上）
### 1. 下载phpunit.phpar

下载地址:https://phar.phpunit.de/phpunit-6.1.phar

- 在linux下将下载好的phpunit-6.1.phpar 移动到/usr/local/bin 目录下

    sudo mv phpunit-6.1.phar /usr/local/bin/phpunit
    
- 在windows下。

新建一个phpunit.cmd 在该文件中输入

    @php "%~dp0phpunit-6.1.phar" %* 

将phpunit.cmd所在的文件目录加入到环境变量之中，然后执行phpunit -version 检验一下是否成功。

    
### 使用composer 安装。

    composer require --dev phpunit/phpunit ^6.1