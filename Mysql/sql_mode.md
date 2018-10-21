## SQL_MODE

sql_mode 是限制执行sql的一种模式，比如有时候我们本地的sql没问题，但是到了线上就出了问题，这个时候就需要考虑是不是`sql_mode` 导致的。sql语法基本上是通用的。但是会`sql_mode` 会限制一些影响。

### 1. 查看sql_mode

```mysql
mysql> show variables like '%sql_mode%'
```

### 2. 修改sql_mode

```sql
Set sql_mode='NO_ENGINE_SUBSITUTION,STRICT_TRANS_TABLES'
```

修改配置文件

```ini
[mysqld]
sql_mode=NO_ENGINE_SUBSTITUTION
```

### sql_mode 常用值介绍

SQL Mode 定义了两个方面：MySQL应支持的SQL语法，以及应该在数据上执行何种确认检查。

- SQL语法支持类

  - ONLY_FULL_GROUP_BY

    对于聚合操作，我们select的列，having或者order by的列 必须在group by中出现。

    ```sql
    mysql > select name,age,birthday from user group by birthday; --- 这就是一个不合法的。但是你如果不设置ONLY_FULL_GROUP_BY ，它不会报错。
    ```

  - ANSI_QUOTES

    启用这个参数后，就不能实用双引号来引用字符串，因为它会被解释为识别符。

    ```sql
    mysql> update t set u = "" #就会报错 因为这个"" 等于``
    ```

  - PIPES_AS_CONCAT

    将 `||` 视为字符串的连接操作符而非 或 运算符

  - NO_AUTO_CREATE_USER

    在给MySQL用户授权时，我们习惯使用 `GRANT ... ON ... TO dbuser` 顺道一起创建用户。设置该选项后就与oracle操作类似，授权之前必须先建立用户。5.7.7开始也默认了

- 数据检查类

  - NO_ZERO_DATE

    就是认为日期 ‘0000-00-00’ 非法

  - STRICT_TRANS_TABLES

    这是就是开启严格模式。它会出现集中限制

    1. 如果我们字符传给int 就会非法。
    2. out of range 变成插入最大边界值
    3. not null 和default 不能同时使用



  下面是几个模式，是各种模式的 组合

- **ANSI**

  更改语法和行为，使其更符合标准SQL
  相当于`REAL_AS_FLOAT, PIPES_AS_CONCAT, ANSI_QUOTES, IGNORE_SPACE`

  1. **REAL_AS_FLOAT** ：REAL 为 FLOAT 的同义词(默认情况, REAL 为 DOUBLE 的同义词).

  2. **PIPES_AS_CONCAT** ： 管道符(||) 作为连接符.(默认使用函数 CONCAT 连接字符)

  3. **ANSI_QUOTES** ：标准引号, 双引号不作为字符串引号，作为关键字标识符引

     ```sql
     create table "max"(id int);  #报错 sql_mode='';
     create table "max"(id int);  #不报错 sql_mode='ANSI_QUOTES';
     ```

  4. **IGNORE_SPACE** ：对于内置函数与其他字符间的空格，忽略空格！

- TRADITIONAL
  严格模式，当向mysql数据库插入数据时，进行数据的严格校验，保证错误数据不能插入，报error错误。用于事物时，会进行事物的回滚



> MySQL 5.7.4 以前版本 和 MySQL 5.7.8 及以上版本：
> STRICT_TRANS_TABLES, STRICT_ALL_TABLES, NO_AUTO_CREATE_USER
> , NO_ENGINE_SUBSTITUTION,NO_ZERO_IN_DATE,   NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO.

> MySQL 5.7.4 至 5.7.7 版本：
> STRICT_TRANS_TABLES, STRICT_ALL_TABLES, NO_AUTO_CREATE_USER,  NO_ENGINE_SUBSTITUTION. 
>
> (STRICT_ALL_TABLES / STRICT_TRANS_TABLES 包含 NO_ZERO_IN_DATE, NO_ZERO_DATE, ERROR_FOR_DIVISION_BY_ZERO)

5.6.6 以后版本默认就是`NO_ENGINE_SUBSTITUTION,STRICT_TRANS_TABLES`，5.5默认为 ‘’

5.7 默认模式：`ONLY_FULL_GROUP_BY, STRICT_TRANS_TABLES, NO_ZERO_IN_DATE,NO_ZERO_DATE, ERROR_FOR_DIVISION_BY_ZERO, NO_AUTO_CREATE_USER, NO_ENGINE_SUBSTITUTION`
