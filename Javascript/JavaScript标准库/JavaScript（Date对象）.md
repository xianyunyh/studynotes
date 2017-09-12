## Date对象

Date对象是js的内置对象，参数可以是string

1. 从1970年1月1日00:00:00 UTC开始计算的毫秒数作为参数
2. 日期字符串作为参数
3. new Date(year, month [, day, hours, minutes, seconds, ms])

```
- year：四位年份，如果写成两位数，则加上1900
- month：表示月份，0表示一月，11表示12月
- date：表示日期，1到31
- hour：表示小时，0到23
- minute：表示分钟，0到59
- second：表示秒钟，0到59
- ms：表示毫秒，0到999
```

### 日期计算

两个日期对象进行减法运算，返回的就是它们间隔的毫秒数；

进行加法运算，返回的就是连接后的两个字符串

```
var d1 = new Date(2000, 2, 1);
var d2 = new Date(2000, 3, 1);

d2 - d1
// 2678400000

```

### Date  静态方法

1. Date.now()

Date.now方法返回当前距离1970年1月1日 00:00:00 UTC的毫秒数（Unix时间戳乘以1000）

2. Date.parse()

Date.parse方法用来解析日期字符串，返回距离1970年1月1日 00:00:00的毫秒数

> 标准的日期字符串的格式，应该完全或者部分符合RFC 2822和ISO 8061，即YYYY-MM-DDTHH:mm:ss.sssZ格式

```
Date.parse("2017-08-01 12:00:00")
```
3. Date.UTC()

Date.UTC方法可以返回UTC时间（世界标准时间）

### Date实例对象的方法

Date的实例对象，有几十个自己的方法，分为以下三类

- to类：从Date对象返回一个字符串，表示指定的时间。



- get类：获取Date对象的日期和时间。
- set类：设置Date对象的日期和时间


- getTime()：返回距离1970年1月1日00:00:00的毫秒数，等同于valueOf方法。
- getDate()：返回实例对象对应每个月的几号（从1开始）。
- getDay()：返回星期几，星期日为0，星期一为1，以此类推。
- getYear()：返回距离1900的年数。
- getFullYear()：返回四位的年份。
- getMonth()：返回月份（0表示1月，11表示12月）。
- getHours()：返回小时（0-23）。
- getMilliseconds()：返回毫秒（0-999）。
- getMinutes()：返回分钟（0-59）。
- getSeconds()：返回秒（0-59）。
- getTimezoneOffset()：返回当前时间与UTC的时区差异，以分钟表示，返回结果考虑到了夏令时因素。

get返回的都是整数

> 分钟和秒：0 到 59
小时：0 到 23
星期：0（星期天）到 6（星期六）
日期：1 到 31
月份：0（一月）到 11（十二月）
年份：距离1900年的年数



- setDate(date)：设置实例对象对应的每个月的几号（1-31），返回改变后毫秒时间戳。
- setYear(year): 设置距离1900年的年数。
- setFullYear(year [, month, date])：设置四位年份。
- setHours(hour [, min, sec, ms])：设置小时（0-23）。
- setMilliseconds()：设置毫秒（0-999）。
- setMinutes(min [, sec, ms])：设置分钟（0-59）。
- setMonth(month [, date])：设置月份（0-11）。
- setSeconds(sec [, ms])：设置秒（0-59）。
- setTime(milliseconds)：设置毫秒时间戳。


```

new Date().getMonth() // 7 表示8月

new Date().getYear() // 117 2017-1900

new Date().getFullYear() // 2017

```