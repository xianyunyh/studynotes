## MySQL 几种 join

我们在使用MySQL的时候，经常需要进行`join` 表的操作，主要的`join` 有  **左连接**、**右连接**、**全连接**、**交叉连接**
一个表连接自己叫自连接


假设有两个表学生表和班级班

 学生表 student

| uid  | uname | classid |
| ---- | ----- | ------- |
| 1    | 张三  | 1       |
| 2    | 李四  | 2       |
| 3    | 王二  | 3       |

班级表 class

| classid | classname |
| ------- | --------- |
| 1       | 一班      |
| 2       | 二班      |
| 4       | 四班      |

### 1. 左外连接 LEFT JOIN

```sql
select * from student left join class on student.classid = class.classid
```

| uid  | uname | classid | classname |
| ---- | ----- | ------- | --------- |
| 1    | 张三  | 1       | 一班      |
| 2    | 李四  | 2       | 二班      |
| 3    | 王二  | 3       | null      |

### 2. 右外连接 RIGHT join

```sql
select * from student right join class on student.classid = class.classid
```

| uid  | uname | classid | classname |
| ---- | ----- | ------- | --------- |
| 1    | 张三  | 1       | 一班      |
| 2    | 李四  | 2       | 二班      |
| null | null  | 4       | 四班      |

### 3. 全外连接 FULL JOIN

全外连接返回参与连接的两个数据集合中的全部数据，无论它们是否具有与之相匹配的行

```sql
select * from student full join class on class.classid = student.classid
```

### 4. 自连接

```sql
select * from student as a  left join student as b on a.uid = b.uid
```
| uid  | uname | classid | uid1  | uname1 | classid1 |
| ---- | ----- | ------- | ---- | ----- | ------- |
| 1    | 张三  | 1       | 1    | 张三  | 1       |
| 2    | 李四  | 2       | 2    | 李四  | 2       |
| 3    | 王二  | 3       | 3    | 王二  | 3       |

