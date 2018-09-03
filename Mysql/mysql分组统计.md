## 按天、星期、月、季度、年进行分组统计

在开发的需求种，经常遇到一些各种需求，最近就遇到了这种按天、星期、月、季度的统计。

最初的想法，是把数据拿出来，然后用程序进行分组，但是后来想了想，还是用mysql的分组来实现。

假设有一个表`tc_case`, `create_time` 为时间戳

### 1. 按天

```sql
select DATE_FORMAT(create_time,'%Y%m%d') days,count(id) as count from tc_case group by days;
```

### 2. 按星期

```sql
select DATE_FORMAT(create_time,'%Y%u') weeks,count(id) count from tc_case group by weeks;
```

### 3. 按月

```sql
select DATE_FORMAT(create_time,'%Y%m') months,count(id) count from tc_case group by months;
```

### 4. 按季度

```sql
select FLOOR((date_format(col, '%m')+2)/3)) as quarter,sum(views) from tc_case group by quarter; 
```

### 5. 按年

```sql
select DATE_FORMAT(create_time,'%Y') year,count(id) as  count from tc_case group by year;
```

