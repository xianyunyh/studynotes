## ElasticSearch基本概念

### Node和Cluster

Elastic 本质上是一个分布式数据库，允许多台服务器协同工作，每台服务器可以运行多个 Elastic 实例。

单个 Elastic 实例称为一个节点（node）。一组节点构成一个集群（cluster）。

### Index

Elastic 会索引所有字段，经过处理后写入一个反向索引（Inverted Index）。查找数据的时候，直接查找该索引。

所以，Elastic 数据管理的顶层单位就叫做 Index（索引）。它是单个数据库的同义词。每个 Index （即数据库）的名字必须是小写。类似关系型数据库的**表**的概念

### Document

Index 里面单条的记录称为 Document（文档）。许多条 Document 构成了一个 Index。

Document 使用 JSON 格式表示，文档就是类似关系型数据库中**行**的概念

### Type

Document 可以分组，比如weather这个 Index 里面，可以按城市分组（北京和上海），也可以按气候分组（晴天和雨天）。这种分组就叫做 Type，它是虚拟的逻辑分组，用来过滤 Document。

## 基本操作

### 新建和删除 Index

新建一个index

```shell
curl -X PUT 'localhost:9200/weather'
```
删除一个index

```shell
curl -X DELETE 'localhost:9200/weather'
```

### document 操作
向指定的 /Index/Type 发送 PUT 请求，就可以在 Index 里面新增一条记录

```shell
curl -X PUT 'localhost:9200/accounts/person/1' -d '
{
  "user": "张三",
  "title": "工程师",
  "desc": "数据库管理"
}' 
```
- 查看记录 [GET]

```shell 
 curl 'localhost:9200/accounts/person/1?pretty=true'
```
- 删除记录 [DELETE]

```shell
curl -X DELETE 'localhost:9200/accounts/person/1'
```
-  更新记录[post]

```shell
curl -X PUT 'localhost:9200/accounts/person/1' -d '
{
    "user" : "张三",
    "title" : "工程师",
    "desc" : "数据库管理，软件开发"
}'
```
-  数据查询

使用 GET 方法，直接请求/Index/Type/_search，就会返回所有记录。

```shell
curl 'localhost:9200/accounts/person/_search'
```
返回字段解释

total：返回记录数，本例是2条。
max_score：最高的匹配程度，本例是1.0。
hits：返回的记录组成的数组。

- 全文搜索

	- query 是匹配的条件
	- size是返回的条数
	- from 起始位置
	
```shell
{
  "query" : { "match" : { "desc" : "软件" }},
"size" : 1,
"from": 1,
}'

curl 'localhost:9200/accounts/person/_search'  -d '
{
  "query" : { "match" : { "desc" : "软件" }}
}'
```