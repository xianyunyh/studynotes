我们在写sql的时候，尽量不要使用使用子查询，而改成join或者exist

```sql
 select a.* from a where a.id (select b.id from b)
```

- 改成exist
```sql
SELECT
    * 
FROM
    a 
WHERE
    EXISTS ( SELECT 1 FROM b WHERE a.id = b.id )
```
- 改成join
```sql
select a.* from a inner join b on a.id = b.id
```
## NOT IN 改成 NOT EXIST/LEFT JOIN

```sql
SELECT
    * 
FROM
    tbl1 
WHERE
    col3 NOT IN ( SELECT col3 FROM tbl2 )
```
- 改成not exist

```sql
SELECT
    * 
FROM
    tbl1 
WHERE
    NOT EXISTS ( SELECT 1 FROM tbl2 WHERE tbl1.col3 = tbl2.col3 )
```
- 改成left join
```sql
SELECT
    * 
FROM
    tbl1
    LEFT JOIN tbl2 ON tbl1.col3 = tbl2.col3 
WHERE
    tbl2.col3 IS NULL
```
