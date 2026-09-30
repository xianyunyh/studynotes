
## `<router-link>`

> `<router-link>` 组件支持用户在具有路由功能的应用中（点击）导航。通过 `to` 属性指定目标地址，默认渲染成带有正确链接的 `<a>` 标签，也可以通过配置 `tag` 属性生成其他标签。另外，当目标路由成功激活时，链接元素会自动设置表示激活状态的 CSS 类名。

### props 


 - to
 
表示目标路由的链接。当被点击后，内部会立刻把 to 的值传到 router.push()

    <router-linker to="/home"></router-link>
    <router-linker to="{path:'/home'}"></router-liner>
    
- replace

 设置 replace 属性的话，当点击时，会调用 router.replace() 而不是 router.push()，于是导航后不会留下 history 记录。

- append

设置 append 属性后，则在当前（相对）路径前添加基路径

    <router-linker to="{path:'/home'}" append></router-liner>
    
- tag

将router-linker渲染成各种指定的标签 默认a

     <router-link to="/reg" tag="p">路由tag</router-link>
     
     
## `<router-view>`

> `<router-view>` 是一个 functional 组件，用于渲染路径匹配到的视图组件。它也可以嵌套其他 `<router-view>`，根据嵌套路径渲染相应组件。

### 属性


- `name`

如果 `<router-view>` 设置了名称，则会渲染对应路由配置中 `components` 下的相应组件。查看命名视图中的例子。