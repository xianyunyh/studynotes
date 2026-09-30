一个变量有值和类型 创建一个 `a` 会创建一个`zval`结构体。这个结构体包含的这个变量的值和变量的类型。标量类型根据值来读取值

```c
#define Z_TYPE_FLAGS(zval)			(zval).u1.v.type_flags
typedef struct _zval {
  zend_value        value; //变量实际的value
    union {
        struct {
            ZEND_ENDIAN_LOHI_4(
                zend_uchar    type,         //变量类型
                zend_uchar    type_flags,  //类型掩码，不同的类型会有不同的几种属性，内存管理会用到
                zend_uchar    const_flags,
                zend_uchar    reserved)     //call info，zend执行流程会用到
        } v;
        uint32_t type_info; //上面4个值的组合值，可以直接根据type_info取到4个对应位置的值
    } u1;
  
} zval
typedef union _zend_value {
    zend_long         lval;    //int整形
    double            dval;    //浮点型
    zend_refcounted  *counted;
    zend_string      *str;     //string字符串
    zend_array       *arr;     //array数组
    zend_object      *obj;     //object对象
    zend_resource    *res;     //resource资源类型
    zend_reference   *ref;     //引用类型，通过&$var_name定义的
    zend_ast_ref     *ast;     //下面几个都是内核使用的value
    zval             *zv;
    void             *ptr;
    zend_class_entry *ce;
    zend_function    *func;
    struct {
        uint32_t w1;
        uint32_t w2;
    } ww;
} zend_value;

typedef struct _zend_refcounted_h {
	uint32_t         refcount;/* 引用计数 32-bit 2^32 */
	union {
		uint32_t type_info;
	} u;
} zend_refcounted_h
```

布尔和null 不存储值。通过类型判断.

```c
if (zval.u1.v.type <=3 ){}

```

### 1. 标量类型

> 最简单的类型是true、false、long、double、null，其中true、false、null没有value，直接根据type区分，而long、double的值则直接存在value中：zend_long、double，也就是标量类型不需要额外的value指针。

### 2. 字符串 是 zend_string

```c
struct _zend_string {
  zend_refcounted gc;
  zend_ulong h;
  size_t len;
  char val[1];
}
```

- gc 变量引用信息
- h 哈希值 数组中计算索引中使用
- len 字符串长度
- val 字符串的内容

由于结构体字节对齐。给一个结构体分配内存。最后的部分就是val的大小。val的地址紧跟len地址

```c
char *str = "hello" 
struct _zend_string  *p = (struct _zend_string *)malloc(sizeof(struct _zend_string )+strlen(str));
p->val// 访问的就是内存中字符串的内容
```

> 为了让CPU能够更舒服地访问到变量，struct中的各成员变量的存储地址有一套对齐的机制。这个机制概括起来有两点：第一，每个成员变量的首地址，必须是它的类型的对齐值的整数倍，如果不满足，它与前一个成员变量之间要填充(padding)一些无意义的字节来满足；第二，整个struct的大小，必须是该struct中所有成员的类型中对齐值最大者的整数倍，如果不满足，在最后一个成员后面填充。

### 3. 数组

PHP中的数组是一个哈希表

`bucket` 就是每个哈希对应的

```c
typedef struct _Bucket {
	zval              val;
	zend_ulong        h;                /* hash value (or numeric index)   */
	zend_string      *key;              /* string key or NULL for numerics */
} Bucket;

typedef struct _zend_array HashTable;

typedef struct _zend_array HashTable;

struct _zend_array {
    zend_refcounted_h gc; //引用计数信息，与字符串相同
    union {
        struct {
            ZEND_ENDIAN_LOHI_4(
                zend_uchar    flags,
                zend_uchar    nApplyCount,
                zend_uchar    nIteratorsCount,
                zend_uchar    reserve)
        } v;
        uint32_t flags;
    } u;
    uint32_t          nTableMask; //计算bucket索引时的掩码
    Bucket           *arData; //bucket数组
    uint32_t          nNumUsed; //已用bucket数
    uint32_t          nNumOfElements; //已有元素数，nNumOfElements <= nNumUsed，因为删除的并不是直接从arData中移除
    uint32_t          nTableSize; //数组的大小，为2^n
    uint32_t          nInternalPointer; //数值索引
    zend_long         nNextFreeElement;
    dtor_func_t       pDestructor;
};
```

- `nNumUsed`已用bucket数
- `nNumOfElements` lenght `count($arr)`

当删除数组里的元素。arData元素不会被立即删除

### 4. 对象/资源

```c
typedef struct _zend_object     zend_object;
struct _zend_object {
	zend_refcounted_h gc;
	uint32_t          handle; // TODO: may be removed ???
	zend_class_entry *ce;
	const zend_object_handlers *handlers;
	HashTable        *properties;
	zval              properties_table[1];
};
struct _zend_resource {
	zend_refcounted_h gc;
	int               handle; // TODO: may be removed ???
	int               type;
	void              *ptr;
};
```

### 5.引用类型

```c
struct _zend_reference {
	zend_refcounted_h gc;
	zval              val;
};
```

在PHP中通过`&`操作符产生一个引用变量，也就是说不管以前的类型是什么，`&`首先会创建一个`zend_reference`结构，其内嵌了一个zval，这个zval的value指向原来zval的value(如果是布尔、整形、浮点则直接复制原来的值)，然后将原zval的类型修改为IS_REFERENCE，原zval的value指向新创建的`zend_reference`结构。

```c
$a = "time:" . time();      //$a    -> zend_string_1(refcount=1)
$b = &$a;                   //$a,$b -> zend_reference_1(refcount=2) -> zend_string_1(refcount=1)
```

## 引用计数

引用计数是指在value中增加一个字段`refcount`记录指向当前value的数量，变量复制、函数传参时并不直接硬拷贝一份value数据，而是将`refcount++`，变量销毁时将`refcount--`，等到`refcount`减为0时表示已经没有变量引用这个value，将它销毁即可。

```c
typedef struct _zend_refcounted_h {
	uint32_t         refcount;			/* reference counter 32-bit */
	union {
		uint32_t type_info;
	} u;
} zend_refcounted_h;
```

- refcount 引用数

这个结构只有当zend_value 为指针的时候，对应的类型才会嵌套。当值是int、double的时候，直接拷贝。

事实上并不是所有的PHP变量都会用到引用计数，标量：true/false/double/long/null是硬拷贝自然不需要这种机制

**支持引用计数的value类型其`zval.u1.type_flag` 包含 (注意是&，不是等于)`IS_TYPE_REFCOUNTED`：**

```
#define IS_TYPE_REFCOUNTED          (1<<2)
```

下面具体列下哪些类型会有这个标识：

```
|     type       | refcounted |
+----------------+------------+
|simple types    |            |
|string          |      Y     |
|interned string |            |
|array           |      Y     |
|immutable array |            |
|object          |      Y     |
|resource        |      Y     |
|reference       |      Y     |
```

- **interned string：** 内部字符串，这是种什么类型？我们在PHP中写的所有字符都可以认为是这种类型，比如function name、class name、variable name、静态字符串等等，我们这样定义:`$a = "hi~";`后面的字符串内容是唯一不变的，这些字符串等同于C语言中定义在静态变量区的字符串：`char *a = "hi~";`，这些字符串的生命周期为request期间，request完成后会统一销毁释放，自然也就无需在运行期间通过引用计数管理内存。
- **immutable array：** 只有在用opcache的时候才会用到这种类型，不清楚具体实现，暂时忽略

## 写时复制

不是所有类型都可以copy的，比如对象、资源，事实上只有string、array两种支持，与引用计数相同，也是通过`zval.u1.type_flag`标识value是否可复制的：

```
#define IS_TYPE_COPYABLE         (1<<4)
|     type       |  copyable  |
+----------------+------------+
|simple types    |            |
|string          |      Y     |
|interned string |            |
|array           |      Y     |
|immutable array |            |
|object          |            |
|resource        |            |
|reference       |            |
```

**copyable** 的意思是当value发生duplication时是否需要或者能够copy，这个具体有两种情形下会发生：

- a.从 **literal变量区** 复制到 **局部变量区** ，比如：`$a = [];`实际会有两个数组，而`$a = "hi~";//interned string`则只有一个string
- b.局部变量区分离时(写时复制)：如改变变量内容时引用计数大于1则需要分离，`$a = [];$b = $a; $b[] = 1;`这里会分离，类型是array所以可以复制，如果是对象：`$a = new user;$b = $a;$a->name = "dd";`这种情况是不会复制object的，$a、$b指向的对象还是同一个

### 变量回收

PHP变量的回收主要有两种：主动销毁、自动销毁。主动销毁指的就是 **unset** ，而自动销毁就是PHP的自动管理机制，在return时减掉局部变量的refcount

### 垃圾回收

PHP变量的回收是根据refcount实现的，当unset、return时会将变量的引用计数减掉，如果refcount减到0则直接释放value。但是现实中会出现循环引用，需要新的回收算法

```php
$a = [1,3,3];
$a[] = $a;

class App {
  
  public function __construct()
  {
    $this->app = $this;
  }
}
```

目前垃圾只会出现在`array`、`object`两种类型中，所以只会针对这两种情况作特殊处理：当销毁一个变量时，如果发现减掉`refcount`后仍然大于0，且类型是`IS_ARRAY`、`IS_OBJECT`则将此value放入gc可能垃圾双向链表中，等这个链表达到一定数量后启动检查程序将所有变量检查一遍，如果确定是垃圾则销毁释放

```c
#define IS_TYPE_COLLECTABLE
```

- [垃圾回收](https://github.com/pangudashu/php7-internal/blob/master/5/gc.md)

### 回收过程

如果当变量的refcount减少后大于0，PHP并不会立即进行对这个变量进行垃圾鉴定，而是放入一个缓冲buffer中，等这个buffer满了以后(10000个值)再统一进行处理，加入buffer的是变量zend_value的`zend_refcounted_h`:

```c
typedef struct _zend_refcounted_h {
    uint32_t         refcount; //记录zend_value的引用数
    union {
        struct {
            zend_uchar    type,  //zend_value的类型,与zval.u1.type一致
            zend_uchar    flags, 
            uint16_t      gc_info //GC信息，垃圾回收的过程会用到
        } v;
        uint32_t type_info;
    } u;
} zend_refcounted_h;
```


