## Mysql ID自增

我们在一般设计表的时候，用的`auto_increamnet`  几种操作会对这个auto_increment 造成影响

```sql
CREATE TABLE `t1` (
	`id` INT ( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID，自增',
	`name` VARCHAR ( 20 ) NOT NULL DEFAULT '' COMMENT '用户昵称',
	PRIMARY KEY ( `id` )
) ENGINE = INNODB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8 ;
```

### 1. insert插入新数据

```sql
insert into t(name) values('test')
```

插入一条记录 会造成主键的自增，这是我们一般默认的，也是正常

### 2. Replace Into 

```sql
replace INTO t1 values (1,'test2')
```

**Affected rows: 2, Time: 0.001000s**

 replace into会导致auto_increment的值自增



### 3. INSERT ... ON DUPLICATE KEY UPDATE ...对主键的影响

```
INSERT INTO t1
VALUES
	( 1,"test") ON DUPLICATE KEY UPDATE NAME =
VALUES
	( NAME );
```

 也会导致影响两行，

