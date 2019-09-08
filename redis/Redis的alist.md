## Redis alist

redis 的`alist` 是双向链表。 实现的很直白，学过数据结构的基本上都能看懂。

```c
typedef struct listNode {
    struct listNode *prev;
    struct listNode *next;
    void *value;
} listNode;
typedef struct list {
    listNode *head;
    listNode *tail;
    void *(*dup)(void *ptr);
    void (*free)(void *ptr);
    int (*match)(void *ptr, void *key);
    unsigned long len;
} list;
typedef struct listIter {
    listNode *next;
    int direction;
} listIter;
```

`listNode` 是节点，节点有`prev` 和`next` 节点

`void *(*dup)(void *ptr);` 这个语法第一次见，google下。发现是给整个结构体增加一个方法。类似面向对象的意思。

- 节点的内容保存在一个 void 指针里面，并且需要向链表提供 dup、free 和 match 函数，通过这种方式使得 Redis 的双向链表可以保存任意内容
- Redis 的双向链表维护了一个 `len` 变量用于保存链表的节点数，因此查询链表节点个数的时间复杂度为 O(1)

### API列表

- `listCreate` 创建一个空链表
- `listEmpty` 清空链表
- `listRelease` 释放链表
- `listAddNodeHead`  增加头节点
- `listAddNodeTail` 增加尾节点
- `list *listInsertNode(list *list, listNode *old_node, void *value, int after);` 在old_node后面或者前面增加一个内容为value指向的节点
- `listDelNode` 删除节点
- `listGetIterator` 获取迭代器
- `listNext` 获取下一个节点
- `list *listDup(list *orig)` 复制整个链表
- `listSearchKey 通过key 搜索节点`
- `listIndex` 通过index获取节点
- `listJoin` 合并两个链表

### 节点的宏

```c
#define listPrevNode(n) ((n)->prev)
#define listNextNode(n) ((n)->next)
#define listNodeValue(n) ((n)->value)
```

### 列表的宏

```c
#define listLength(l) ((l)->len) //列表的长度
#define listFirst(l) ((l)->head) //列表的头
#define listLast(l) ((l)->tail) //列表的尾

#define listSetDupMethod(l,m) ((l)->dup = (m))
#define listSetFreeMethod(l,m) ((l)->free = (m))
#define listSetMatchMethod(l,m) ((l)->match = (m))

#define listGetDupMethod(l) ((l)->dup)
#define listGetFree(l) ((l)->free)
#define listGetMatchMethod(l) ((l)->match)
```

