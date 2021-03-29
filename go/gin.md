Gin框架中间件实现

```go
package main

import "fmt"

type HandlerFun func(c *Context)
type Context struct {
	Handler []HandlerFun
	index   int8
}

func (ctx *Context) Next() {
	ctx.index++
	for ctx.index < int8(len(ctx.Handler)) {
		ctx.Handler[ctx.index](ctx)
		ctx.index++
	}
}
func (ctx *Context) AddHandler(handlers ...HandlerFun) {
	ctx.Handler = append(ctx.Handler, handlers...)
}
func NewContext() *Context {
	return &Context{
		Handler: make([]HandlerFun, 0),
		index:   -1,
	}
}

func main() {
	ctx := NewContext()
	ctx.AddHandler(func(c *Context) {
		fmt.Println("1 begin")
		c.Next()
		fmt.Println("1 end")

	}, func(c *Context) {
		fmt.Println("2 begin")
		c.Next()
		fmt.Println("2 end")

	}, func(c *Context) {
		fmt.Println("3 begin")
		c.Next()
		fmt.Println("3 end")
	})
	ctx.Next()
}

```
