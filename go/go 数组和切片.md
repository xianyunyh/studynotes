## slice源码解读

```go
type slice struct {
	array unsafe.Pointer
	len   int
	cap   int
}
```

- Len slice的长度
- cap slice的容量
- array 指向底层数组

### 创建切片

```go
func makeslice(et *_type, len, cap int) unsafe.Pointer {
	mem, overflow := math.MulUintptr(et.size, uintptr(cap))
	if overflow || mem > maxAlloc || len < 0 || len > cap {
		mem, overflow := math.MulUintptr(et.size, uintptr(len))
		if overflow || mem > maxAlloc || len < 0 {
			panicmakeslicelen()
		}
		panicmakeslicecap()
	}
	//分配空间
	return mallocgc(mem, et, true)
}
```



### 切片扩容

```go
func growslice(et *_type, old slice, cap int) slice {
	if cap < old.cap {
		panic(errorString("growslice: cap out of range"))
	}
  //切片元素长度是0的时候
	if et.size == 0 {
		return slice{unsafe.Pointer(&zerobase), old.len, cap}
	}

	newcap := old.cap
	doublecap := newcap + newcap
	if cap > doublecap {
		newcap = cap
	} else {
    //扩容一倍
		if old.cap < 1024 {
			newcap = doublecap
		} else {
      //扩容1/4
			for 0 < newcap && newcap < cap {
				newcap += newcap / 4
			}
			if newcap <= 0 {
				newcap = cap
			}
		}
	}

	...
	memmove(p, old.array, lenmem)

	return slice{p, old.len, newcap}
}
```

- 切片扩容策略，
  - 容量小于1024的时候，扩容1倍 `oldCap + oldCap`
  - 容量大于1024，扩容0.25 `newcap = oldCap +  (oldCap / 4)`

### 切片复制

```go
func slicecopy(toPtr unsafe.Pointer, toLen int, fromPtr unsafe.Pointer, fromLen int, width uintptr) int {
  //width 切片元素大小
  //toPtr 目前切片
  //toLen 目标长度
	if fromLen == 0 || toLen == 0 {
		return 0
	}

	n := fromLen
	if toLen < n {
		n = toLen
	}

	if width == 0 {
		return n
	}

	size := uintptr(n) * width
	if size == 1 {
		*(*byte)(toPtr) = *(*byte)(fromPtr) // known to be a byte pointer
	} else {
		memmove(toPtr, fromPtr, size)
	}
	return n
}
```

将对应大小的元素复制到对应的内存空间
