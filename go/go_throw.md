在go语言中，有一些错误panic 我们可以通过`recover`来恢复，但是有一些语言底层抛的，致命错误，我们无法捕获

## throw
throw 是最常见的错误。比如map并发读写不安全，就会出现致命错误

```go
func test() {
 m := map[string]int{}
 
 go func() {
  for {
    m["a"] =1
  }
 }()
 
 go func() {
  for {
  _ = m["a"]
  }
 }()
 
 select{}
}
```

### 死锁

```go
func f() {
select{}

}
```
