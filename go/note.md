## 切片

```go
type slice struct {
    array unsafe.Pointer
    len   int
    cap   int
}
```

1. 切片传递

   ```go
   func test(arr []int) {
       arr = appen(arr,1,3)
   }
   func main() {
       a := make([]int,3)
       test(a)
       fmt.Println(a)//[0,0,0]
       fmt.Println(len(a),cap(a))//3，3
   }
   ```

2. 切片分割

   ```go
   func main() {
       arr := []int{1,2,3,4,5,6,7,8}
       arr1 := arr[1:4];//[2,3,4]
       fmt.Println(len(arr1),cap(arr1))//3，7
       arr2 := arr[:3]//[1,2,3]
       fmt.Println(len(arr2),cap(arr2))//3,8
   }
   ```

### map

1. 并发读写不安全

   ```go
   type User struct {
       list map[string]string
       mux sync.Mux
   }
   func main  () {
       user := &User {
           list: make(map[string]string),
           mux: sync.Mux{}
       }
       wg := sync.WaitGroup{}
       wg.Add(200)
       for i := 0;i < 200;i++ {
           go func(i int) {
               user.mux.Lock()
               defer user.mux.Unlock();
               user["name"] = fmt.Sprintf("%d",i)
               wg.Done() 
           }(i)
            go func(i int) {
                for _,v := range user.list {
                    fmt.Println(v)
                } 
           }(i)
       }
       wg.Wait()
   }
   ```

### 3. 结构体

```go
type Animal struct {
}

func (a *Animal) Run() {
	fmt.Println("animal run")
	a.Eat()
}

func (a *Animal) Eat() {
	fmt.Println("animal eat")
}

type Dog struct {
	Animal
}

func (d *Dog) Eat() {
	fmt.Println("dog eat")
}

func main() {
	dog := &Dog{}
	dog.Run()//animal run  animal eat

}
```

### 4. defer

```go
func test() (i int) {


	defer func() {
		i++
		fmt.Println("defer", i)
	}()
	defer func() {
		i++
		fmt.Println("defer", i)
	}()
	return i
}

func main() {
	fmt.Println("return ", test())

}
// defer 1
// defer 2
// return 2

func test() int {
	var i int

	defer func() {
		i++
		fmt.Println("defer", i)
	}()
	defer func() {
		i++
		fmt.Println("defer", i)
	}()
	return i
}

func main() {
	fmt.Println("return ", test())
}
// defer 1
// defer 2
// return 0

func main() {
    var sync.Mutex l
    for i := 0;i < 5;i++ {
        l.Lock()
        defer l.Unlock()
        fmt.Println(i)
    }
}
//0 
// all goroutines are asleep - deadlock!
```

