##全局钩子

> 你可以使用 router.beforeEach 注册一个全局的 before 钩子

每个钩子方法接收三个参数：

- to: Route: 即将要进入的目标 路由对象

- from: Route: 当前导航正要离开的路由

- next: Function: 一定要调用该方法来 resolve 这个钩子。执行效果依赖 next 方法的调用参数。

   - next(): 进行管道中的下一个钩子。如果全部钩子执行完了，则导航的状态就是 confirmed （确认的）。

   - next(false): 中断当前的导航。如果浏览器的 URL 改变了（可能是用户手动或者浏览器后退按钮），那么 URL 地址会重置到 from 路由对应的地址。

   - next('/') 或者 next({ path: '/' }): 跳转到一个不同的地址。当前的导航被中断，然后进行一个新的导航。

确保要调用 next 方法，否则钩子就不会被 resolved

            const router = new VueRouter({
            routes:[
                {
                    path:"/login",
                    component:Login
                },
                {
                    path:'/reg',
                    component:Reg
                },
                {
                    path:'/guard',
                    component:Guard
                }
            ]
        });
        // 全局导航钩子 to from next
        router.beforeEach((to, from, next)=>{
            console.log(to.fullPath)
            console.log(from.fullPath)
            next();//next必须要执行。不然会中断
        });

## 局部钩子

        
        const router = new VueRouter({
            routes:[
                {
                    path:"/login",
                    component:Login,
                   //设置局部钩子，和全局钩子有共同的参数。 beforeEnter:function(to,from,next){
                        console.log(to)
                        console.log(from)
                        console.log(next)
                    }
                },
                {
                    path:'/reg',
                    component:Reg
                },
                {
                    path:'/guard',
                    component:Guard
                }
            ]
        });
        
        
## 组件钩子

beforeRouteEnter
beforeRouteUpdate (2.2 新增)
beforeRouteLeave


        const Guard = {
            template:`<a>组件钩子</a>`,
            beforeRouteEnter (to, from, next) {
                console.log(to.fullPath)
                next();
                // 在渲染该组件的对应路由被 confirm 前调用
                // 不！能！获取组件实例 `this`
                // 因为当钩子执行前，组件实例还没被创建
            },
            beforeRouteUpdate (to, from, next) {
                console.log(to.fullPath)
                next();
                // 在当前路由改变，但是该组件被复用时调用
                // 举例来说，对于一个带有动态参数的路径 /foo/:id，在 /foo/1 和 /foo/2 之间跳转的时候，
                // 由于会渲染同样的 Foo 组件，因此组件实例会被复用。而这个钩子就会在这个情况下被调用。
                // 可以访问组件实例 `this`
            },
            beforeRouteLeave (to, from, next) {
                console.log(to.fullPath)
                next();
                // 导航离开该组件的对应路由时调用
                // 可以访问组件实例 `this`
            }
