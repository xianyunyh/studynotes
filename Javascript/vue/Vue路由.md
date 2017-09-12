## vue 路由

> 模糊匹配路由把某种模式匹配到的所有路由，全都映射到同个组件


    <div id="app">
	<router-link to="/app/aa">aaa</route-link>
	<router-link to="/app/bb">aaa</route-link>
	<router-link to="/app/cc">aaa</route-link>	
	<router-view>
	</router-view>
	  
	</div>
	
	<script type="text/javascript">
	const User = {
	  template: '<div>User {{ $route.params.id }}</div>'
	}
	const router = new VueRouter({
		routes:[
			{
				path:"/app/:id",
				component:User
			}
		]
	})
	var vm = new Vue({
		el:"#app",
		router
	})
	</script>
	
	
## 子路由

        /user/foo/profile                     /user/foo/posts
    +------------------+                  +-----------------+
    | User             |                  | User            |
    | +--------------+ |                  | +-------------+ |
    | | Profile      | |  +------------>  | | Posts       | |
    | |              | |                  | |             | |
    | +--------------+ |                  | +-------------+ |
    +------------------+                  +-----------------+
    
> 实现嵌套路由，需要在父路由中加上router-view 表示子路由渲染的位置。同样地，一个被渲染组件同样可以包含自己的嵌套 `<router-view>`
    
        <div id="app">
    	<div id="box">
            <p>
                <router-link to="/home">home</router-link>
                <router-link to="/home/login">news</router-link>
                <router-link to="/home/reg">news</router-link>
            </p>
              <router-view></router-view>
        </div>
    </div>
    	<script type="text/javascript">
    	var name = "hello";
    	const Home ={
    		template: `<div>
    				${name}
    				<router-view></router-view>
    				</div>
    		`
    	};
    
    	const Login = {
    		template:"<h1>Login</h1>"
    	}
    
    	const Reg = {
    		template : "<h1>注册</h1>"
    	}
    
    	 // 2. 定义路由
        const routes = [
             { path: '/', redirect: '/home' },
            { 
                path: '/home', 
                component: Home, 
                children:[
                    { path: 'login', component: Login},
                    { path: 'reg', component: Reg}
                ]
            }
        ]
        const router = new VueRouter({routes});
    	var vm = new Vue({
    		router
    	}).$mount('#app')
    	</script>
    </body>
    
    
## 编程路由
    
    
除了使用 <router-link> 创建 a 标签来定义导航链接，我们还可以借助 router 的实例方法，通过编写代码来实现。

router.push(location)

>想要导航到不同的 URL，则使用 router.push 方法。这个方法会向 history 栈添加一个新的记录，所以，当用户点击浏览器后退按钮时，则回到之前的 URL

router.replace(location)

跟 router.push 很像，唯一的不同就是，它不会向 history 添加新记录，而是跟它的方法名一样 —— 替换掉当前的 history 记录。


router.go(n)

这个方法的参数是一个整数，意思是在 history 记录中向前或者后退多少步，类似 window.history.go(n)。

    methods:{
        goTo:function(){
            router.push('/home')
            router.go(1)
    }}
    
    
## Vue 命名路由

通过一个名称来标识一个路由显得更方便一些，特别是在链接一个路由

    const router = new VueRouter({
      routes: [
        {
          path: '/user/:userId',
          name: 'user',
          component: User
        }
      ]
    })


    <router-link :to="{ name: 'user', params: { userId: 123 }}">User</router-link>
    
    
## 命名视图


有时候想同时（同级）展示多个视图，而不是嵌套展示，例如创建一个布局，有 sidebar（侧导航） 和 main（主内容） 两个视图，这个时候命名视图就派上用场了

     // 2. 定义路由
       const router = new VueRouter({
    	  routes: [
    	    {
    	      path: '/',
    	      components: {
    	       
    	        a: Header,
    	        b: Slider
    	      }
    	    }
    	  ]
    	})
    	
    	
## 重定向 和 别名


重定向也是通过 routes 配置来完成，下面例子是从 /a 重定向到 /b

        const router = new VueRouter({
          routes: [
            { path: '/a', redirect: { name: 'foo' }}
          ]
        })
        

> 『重定向』的意思是，当用户访问 /a时，URL 将会被替换成 /b，然后匹配路由为 /b，那么『别名』又是什么呢？

> /a 的别名是 /b，意味着，当用户访问 /b 时，URL 会保持为 /b，但是路由匹配则为 /a，就像用户访问 /a 一样

        const router = new VueRouter({
          routes: [
            { path: '/a', component: A, alias: '/b' }
          ]
        })
        
        
## HTML5 History 模式

vue-router 默认 hash 模式 —— 使用 URL 的 hash 来模拟一个完整的 URL

    const router = new VueRouter({
      mode: 'history',
      routes: [...]
    })