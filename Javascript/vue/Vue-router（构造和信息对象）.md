
## vue-router构造

- routes


- mode

类型: string

默认值: "hash" (浏览器环境) | "abstract" (Node.js 环境)

可选值: "hash" | "history" | "abstract"

配置路由模式:

  -  hash: 使用 URL hash 值来作路由。支持所有浏览器，包括不支持 HTML5 History Api 的浏览器。

  - history: 依赖 HTML5 History API 和服务器配置。查看 HTML5 History 模式.

  - abstract: 支持所有 JavaScript 运行环境，如 Node.js 服务器端。如果发现没有浏览器的 API，路由会自动强制进入这个模式。

- base

类型: string

默认值: "/"

应用的基路径。例如，如果整个单页应用服务在 /app/ 下，然后 base 就应该设为 "/app/" 


- linkActiveClass

全局配置 <router-link> 的默认『激活 class 类名


- scrollBehavior 

 function
 
    scrollBehavior(to, from, savedPosition){}
    

    const router = new VueRouter({
        base:"/app/",
        linkActiveClass:"actice",
        mode:"history",
        routes:[
            {},
            {}
        ]
    })
    
## 路由信息对象


> 一个 route object（路由信息对象） 表示当前激活的路由的状态信息，包含了当前 URL 解析得到的信息，还有 URL 匹配到的 route records（路由记录）

### 路由信息对象的属性

- name 

如果有则是命名路由的名字

- fullPath

路由的完整匹配路径

- params

路由的参数

- query

路由的查询的query 生成/user?id=100

 <router-link :to='{path:"login",query:{id:100}}'>query</router-link>