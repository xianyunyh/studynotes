## Redis 开发规范

### 1. 键名建议

- 可读性和可管理性

  以业务名(或数据库名)为前缀(防止key冲突)，用冒号分隔，比如业务名:表名:id。

- 简洁性

  保证语义的前提下，控制key的长度，当key较多时，内存占用也不容忽视 

- 不允许包括特殊字符

  不能包含空格、换行、单双引号以及其他转义字符 



### 2. Value 建议

- 拒绝大key

  string类型控制在10KB以内，hash、list、set、zset元素个数不要超过5000。 

- 选择合适的数据类型

- 控制key的生命周期，redis不是垃圾桶。 

  建议使用expire设置过期时间(条件允许可以打散过期时间，防止集中过期)，不过期的数据重点关注idletime。

  项目里一般强制要求所有都设置过期时间，避免由于redis问题导致服务不可用 

### 3. 命令使用

- O(N)命令 关注N的数量

- 禁用命令

  禁止线上使用keys、flushall、flushdb等，通过redis的rename机制禁掉命令，或者使用scan的方式渐进式处理。 	

- 推荐使用批量操作，提高效率

  原生命令：例如mget、mset。 非原生命令：可以使用pipeline提高效率。 

- redis 事务性能弱，不建议使用



## 参考资料

- [https://yq.aliyun.com/articles/557508](https://yq.aliyun.com/articles/557508)
