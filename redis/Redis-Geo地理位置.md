## Redis Geo 地址位置

redis geo这个功能可以将用户给定的地理位置信息储存起来， 并对这些信息进行操作。
redis 目前提供了以下六个命令。
1、geoadd：增加某个地理位置的坐标。
2、geopos：获取某个地理位置的坐标。
3、geodist：获取两个地理位置的距离。
4、georadius：根据给定地理位置坐标获取指定范围内的地理位置集合。
5、georadiusbymember：根据给定地理位置获取指定范围内的地理位置集合。
6、geohash：获取某个地理位置的geohash值。

> 地理位置的坐标是以WGS84为标准，WGS84，全称World Geodetic System 1984，是为GPS全球定位系统使用而建立的坐标系统。

- geoadd 

geoadd用来增加地理位置的坐标，可以批量添加地理位置，命令格式为：

	GEOADD key longitude latitude member [longitude latitude member ...]

	GEOADD Guangdong-cities 113.2278442 23.1255978 Guangzhou 113.106308 23.0088312 Foshan 113.7943267 22.9761989 Dongguan 114.0538788 22.5551603 Shenzhen


key标识一个地理位置的集合。longitude latitude member标识了一个地理位置的坐标。longitude是地理位置的经度，latitude是地理位置的纬度。member是该地理位置的名称。GEOADD可以批量给集合添加一批地理位置。

- geopos

geopos可以获取地理位置的坐标，可以批量获取多个地理位置的坐标，命令格式为：

	GEOPOS key member [member ...]

	GEOPOS Guangdong-cities  Guangzhou Foshan

- geodist

geodist用来获取两个地理位置的距离，命令格式为：

	GEODIST key member1 member2 [m|km|ft|mi]
	GEODIST Guangdong-cities Shenzhen Guangzhou km

单位可以指定为以下四种类型：

- m：米，距离单位默认为米，不传递该参数则单位为米。
- km：公里。
- mi：英里。
- ft：英尺。

- georadius

georadius可以根据给定地理位置坐标获取指定范围内的地理位置集合

	GEORADIUS key longitude latitude radius [m|km|ft|mi] [WITHCOORD] [WITHDIST] [ASC|DESC] [WITHHASH] [COUNT count]

	 GEORADIUS Guangdong-cities  113.2278442 23.1255978 50 km asc 

longitude latitude标识了地理位置的坐标，radius表示范围距离，距离单位可以为m|km|ft|mi，还有一些可选参数：

- WITHCOORD：传入WITHCOORD参数，则返回结果会带上匹配位置的经纬度。
- WITHDIST：传入WITHDIST参数，则返回结果会带上匹配位置与给定地理位置的距离。
- ASC|DESC：默认结果是未排序的，传入ASC为从近到远排序，传入DESC为从远到近排序。
- WITHHASH：传入WITHHASH参数，则返回结果会带上匹配位置的hash值。
- COUNT count：传入COUNT参数，可以返回指定数量的结果。


- georadiusbymember

georadiusbymember可以根据给定地理位置获取指定范围内的地理位置集合。georadius命令传递的是坐标，georadiusbymember传递的是地理位置。georadius更为灵活，可以获取任何坐标点范围内的地理位置。但是大多数时候，只是想获取某个地理位置附近的其他地理位置，使用georadiusbymember则更为方便。georadiusbymember命令格式为（命令可选参数与georadius含义一样）：

	GEORADIUSBYMEMBER key member radius [m|km|ft|mi] [WITHCOORD] [WITHDIST] [ASC|DESC] [WITHHASH] [COUNT count]

- geohash

geohash可以获取某个地理位置的geohash值。geohash是将二维的经纬度转换成字符串hash值的算法，后面会具体介绍geohash原理。可以批量获取多个地理位置的geohash值。命令格式为：

	GEOHASH key member [member ...]
	GEOHASH Guangdong-cities Shenzhen Guangzhou

### 用途
 可以根据位置作位置搜索。比如附近推荐。