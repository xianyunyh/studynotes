## Redis Sds结构

redis 的sds结构实现字符串的基础。具体的文件有两个`sds.c` `sds.h`

在`sds.h`中我们可以看到sds的结构的定义 

```c
typedef char *sds;
```

这里可以看到就是一个`char *` 的别名。但是后面我们看到他和C的 `char * ` 又不一样。

Sds有五种。分别为`sds5` 、`sds8` 、`sds16` 、`sds32` 、`sds64` 其中`sds5`从未使用过、之所以会有五种类型，就是为了省内存，我们看下其中四种的结构的定义。以`sds8`为例

每个`sds` 所能存取的最大字符串长度为

- `sds5`  对应`1<<5` 32
- `sds8` 对应 `1<<8` 256
- `sds16` 对应 `1<<16` 65536
- `sds32` 对应 `1ll<<32` 2^32
- `sds64` 对应 `1<<16` 2^64

```c
struct __attribute__ ((__packed__)) sdshdr8 {
    uint8_t len; /* used */
    uint8_t alloc; /* excluding the header and null terminator */
    unsigned char flags; /* 3 lsb of type, 5 unused bits */
    char buf[];
};
```

首先`__attribute__ ((__packed__))` 这是告诉编译分配紧凑的内存，而不是字节对齐的方式。因为内存分配的时候，是按字节对齐的，一般都是按一个指针大小为单位进行分配的。比如一个char 也会分配一个指针大小的内存。

- `len` 就是字符串的长度
- `alloc` 字符串的容量
- `flags` 字符串的类型标记 具体的类型有5种 `SDS_TYPE_5`、`SDS_TYPE_8`、`SDS_TYPE_16` 、`SDS_TYPE_32` 、`SDS_TYPE_64`
- buf[] 就是柔性数组。在分配内存的时候会指向字符串的内容

内存是紧凑分配的。所以我们取到字符串的内容的时候，通过指针后退一位`sds[-1]` 就可以得到字符串的类型。 

**sds** 由`sds` 结构体 + `sds`内容组成

### sds的创建

`sds.h` 中的`sdsnew` 和`sdsnewlen` 为创建`sds的`函数

```c
#define SDS_HDR_VAR(T,s) struct sdshdr##T *sh = (void*)((s)-(sizeof(struct sdshdr##T)));
#define SDS_HDR(T,s) ((struct sdshdr##T *)((s)-(sizeof(struct sdshdr##T))))
sds sdsnew(const char *init) {
    size_t initlen = (init == NULL) ? 0 : strlen(init);
    return sdsnewlen(init, initlen);
}
sds sdsnewlen(const void *init, size_t initlen) {
    void *sh;
    sds s;
    char type = sdsReqType(initlen);
    if (type == SDS_TYPE_5 && initlen == 0) type = SDS_TYPE_8;
    int hdrlen = sdsHdrSize(type);
    unsigned char *fp; /* flags pointer. */
	//申请内存
    sh = s_malloc(hdrlen+initlen+1);
    if (init==SDS_NOINIT)
        init = NULL;
    else if (!init)
        memset(sh, 0, hdrlen+initlen+1);
    if (sh == NULL) return NULL;
    s = (char*)sh+hdrlen;
    //获取flags标志位
    fp = ((unsigned char*)s)-1;
    switch(type) {
        //s-sizeof(sds8)
        case SDS_TYPE_8: {
            SDS_HDR_VAR(8,s);
            sh->len = initlen;
            sh->alloc = initlen;
            *fp = type;
            break;
        }
 	// 省略部分代码....
    }
    //复制
    if (initlen && init)
        memcpy(s, init, initlen);
    s[initlen] = '\0';
    return s;
}
```

创建一个`sds` 通过`sdsnew`的函数进行创建，通过`strlen`计算出长度。然后通过`sdsnewlen`创建

首先通过`sdsReqType` 来算出类型。不同长度的字符串对应不同的sds结构。**如果是sds5或者长度是0 则采用sds8**

- 申请内存

  `s_malloc` 申请内存 大小为`hdrlen+initlen+1` = 结构体的长度+字符串长度+1。最后要在字符串的末尾补`\0`。

- 分配内存

  判断具体的类型，然后指针计算 `SDS_HDR_VAR(8,s)` 等价于

  `struct sdshdr8 *sh = (void*)((s)-(sizeof(struct sdshdr8)));` 就是让s找到结构体的地址。

  然后进行结构体的`len` 和 `alloc`赋值操作  `flags` 的赋值则是通过 `s -1` 找到位置。然后将`type` 赋值给 flags `fp = ((unsigned char*)s)-1;`
  
- 填充字符串结尾的`\0`

  将字符串的内容复制到flags后面。大小为`initlen` ，并往字符串的后面的追加一个`\0`



### Sds扩容

`sds.c` 中的`sdsMakeRoomFor`函数是字符串扩容

```c
#define SDS_MAX_PREALLOC (1024*1024)
sds sdsMakeRoomFor(sds s, size_t addlen) {
    void *sh, *newsh;
    size_t avail = sdsavail(s); //剩余容量计算
    size_t len, newlen;
    char type, oldtype = s[-1] & SDS_TYPE_MASK;
    int hdrlen;
    if (avail >= addlen) return s;

    len = sdslen(s);
    sh = (char*)s-sdsHdrSize(oldtype);//得到头的地址
    newlen = (len+addlen);
    //计算扩容大小
    if (newlen < SDS_MAX_PREALLOC)
        newlen *= 2;
    else
        newlen += SDS_MAX_PREALLOC;

    type = sdsReqType(newlen);//计算sds的类型
    if (type == SDS_TYPE_5) type = SDS_TYPE_8;

    hdrlen = sdsHdrSize(type);
    //内存空间分配
    if (oldtype==type) {
        //扩容
        newsh = s_realloc(sh, hdrlen+newlen+1);
        if (newsh == NULL) return NULL;
        s = (char*)newsh+hdrlen;
    } else {
        //重分配
        newsh = s_malloc(hdrlen+newlen+1);
        if (newsh == NULL) return NULL;
        memcpy((char*)newsh+hdrlen, s, len+1);
        s_free(sh);
        s = (char*)newsh+hdrlen;
        s[-1] = type;
        sdssetlen(s, len);
    }
    #设置字符串的容量
    sdssetalloc(s, newlen);
    return s;
}
```

- 计算剩余容量

  剩余容量等于`sh->alloc - sh->len`  如果剩余长度大于需要增加的长度，则直接返回

- 计算扩容大小

  新的空间和 `SDS_MAX_PREALLOC`  1024*1024进行比较

  如果没超过1Mb ，则扩容空间大小为 该字符串长度的2倍 `2 * newlen`

  如果超过1Mb，则增加1Mb大小。

  所以字符串扩容最大只能更增加1Mb

  

- 内存分配

  `newLen` = 新增`addLen` + 原长度`len`  算出sds的类型

  如果新类型=原类型，则进行调整内存大小 为`hdrlen+newlen+1`

  如果新类型 不等于 原类型 内存进行重新分配，创建新的内存块 大小为`hdrlen+newlen+1`，释放旧的地址空间，将新的字符串写入新空间

  设置字符串的容量`sdssetalloc`

### 释放sds未使用的内存

```c
sds sdsRemoveFreeSpace(sds s) {
    void *sh, *newsh;
    char type, oldtype = s[-1] & SDS_TYPE_MASK;
    int hdrlen, oldhdrlen = sdsHdrSize(oldtype);
    size_t len = sdslen(s);
    size_t avail = sdsavail(s);
    sh = (char*)s-oldhdrlen;

    if (avail == 0) return s;

    
    type = sdsReqType(len);
    hdrlen = sdsHdrSize(type);

   //如果类型一样，则调整sds的大小为len+hrdlen+1
    if (oldtype==type || type > SDS_TYPE_8) {
        newsh = s_realloc(sh, oldhdrlen+len+1);
        if (newsh == NULL) return NULL;
        s = (char*)newsh+oldhdrlen;
    } else {
        newsh = s_malloc(hdrlen+len+1);
        if (newsh == NULL) return NULL;
        memcpy((char*)newsh+hdrlen, s, len+1);
        s_free(sh);
        s = (char*)newsh+hdrlen;
        s[-1] = type;
        sdssetlen(s, len);
    }
    sdssetalloc(s, len);
    return s;
}
```

在上面的分配内存，我们看到，扩容的时候，会产生`newlen*2` 或者`newlen+1Mb` 大小的内存块，但是可能会产生大量的内存浪费，在内存紧张的情况，redis 会通过`sdsRemoveFreeSpace`释放掉这些内存。

如果`sds` 实际大小 未超过 `sds` type的范围大小。则需要调整内存，否则进行创建新的内存区域，进行复制。



## 常用API介绍

- `sdslen( sds s)` 计算字符串的长度
- `sdsavail( sds s)` 字符串剩余容量
- `sdssetlen` 修改字符串的长度大小
- `sdsalloc(sds s)` 获取字符串的总容量
- `sdsHdrSize(char type)` 计算`sds` 头的大小，也就是`struct sds`的大小
- `sdsReqType(size_t size)`  根据size 计算出类型
- `sdsnew` 创建一个 `sds`
- `sdsfree` 释放`sds` 内存 对应于 c中的`free`
- `sdsMakeRoomFor` 扩容
- `sdsAllocSize` 获取sds 总共的大小 = sds结构体头+ sds内容+1

## 常用宏定义

类型定义

```c
#define SDS_TYPE_5  0
#define SDS_TYPE_8  1
#define SDS_TYPE_16 2
#define SDS_TYPE_32 3
#define SDS_TYPE_64 4
#define SDS_TYPE_MASK 7
#define SDS_TYPE_BITS 3
```

- `SDS_HDR_VAR()` 就是返回结构体的头地址
- `SDS_HDR` 返回的就是`sds` 内容的地址。通过这个地址-1.就可以获取到flags地址

```c
#define SDS_HDR_VAR(T,s) struct sdshdr##T *sh = (void*)((s)-(sizeof(struct sdshdr##T)));
//N代表具体的数字 分别对应 5、8、16、 32、64
//等价于 struct sdshdrN *sh = (void*)((s)-(sizeof(struct sdshdrN))); 

#define SDS_HDR(T,s) ((struct sdshdr##T *)((s)-(sizeof(struct sdshdr##T))))
//((struct sdshdrN *)((s)-(sizeof(struct sdshdrN))))

```

```c
static inline char sdsReqType(size_t string_size) {
    if (string_size < 1<<5)
        return SDS_TYPE_5;
    if (string_size < 1<<8)
        return SDS_TYPE_8;
    if (string_size < 1<<16)
        return SDS_TYPE_16;
#if (LONG_MAX == LLONG_MAX)
    if (string_size < 1ll<<32)
        return SDS_TYPE_32;
    return SDS_TYPE_64;
#else
    return SDS_TYPE_32;
#endif
}
```

## 内存分配函数

- `sds_malloc`  对应于 `malloc`  **zmalloc** 申请内存
- `sds_realloc` 对应`realloc` **zrealloc** 调整内存
- `sds_free` 对应 `free` **zfree** 释放内存
