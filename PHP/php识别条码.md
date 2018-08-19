## 利用php识别条码

>php 识别条形码拓展php-zbarcode 该拓展依赖ImageMagick和zbar

1. 安装ImageMagick依赖

		> yum install ImageMagick ImageMagick-devel

2. 安装zbar拓展

        > wget -c http://jaist.dl.sourceforge.net/project/zbar/zbar/0.10/zbar-0.10.tar.bz2
		> tar jxvf zbar-0.10.tar.bz2
		> cd zbar-0.10
		> ./configure --without-gtk --without-python --without-qt --prefix=/usr/local/zbar ##禁止gtk,python和qt的支持
		> make && make install


3. 安装php-zbarcode

		> git clone https://github.com/mkoppanen/php-zbarcode.git 
		> cd php-zbarcode
		> /usr/local/php/bin/phpize #自己phpize的位置
		> ./configure --with-php-config=/usr/local/php/bin/php-config --with-zbarcode=/usr/local/zbar/
		> make && make install

4. 添加extension=zbarcode.so 到php.ini中 然后重启apache

### 测试phpzbarcode的效果

		<?php  
		    //新建一个图像对象  
		    $image = new ZBarCodeImage("test.png");  
		  
		    // 创建一个二维码识别器  
		    $scanner = new ZBarCodeScanner();  
		  
		    //识别图像  
		    $barcode = $scanner->scan($image);  
		  
		    //循环输出二维码信息  
		    if (!empty($barcode)) {  
		        foreach ($barcode as $code) {  
		            echo $code['type'];//图像的条码类型
					echo $code['data'];//条码的数据 
		        }  
		    }  
		?>  

	
