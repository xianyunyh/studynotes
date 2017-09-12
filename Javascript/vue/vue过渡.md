## Vue过渡效果

Vue 提供了 transition 的封装组件，在下列情形中，可以给任何元素和组件添加 entering/leaving 过渡
条件渲染 （使用 v-if）
条件展示 （使用 v-show）
动态组件
组件根节点


### 过渡的-CSS-类名

会有 4 个(CSS)类名在 enter/leave 的过渡中切换
v-enter: 定义进入过渡的开始状态。在元素被插入时生效，在下一个帧移除。
v-enter-active: 定义进入过渡的结束状态。在元素被插入时生效，在 transition/animation 完成之后移除。
v-leave: 定义离开过渡的开始状态。在离开过渡被触发时生效，在下一个帧移除。
v-leave-active: 定义离开过渡的结束状态。在离开过渡被触发时生效，在 transition/animation 完成之后移除。

v- 是这些类名的前缀


### 自定义过渡类名

我们可以通过以下特性来自定义过渡类名：

- enter-class
- enter-active-class
- leave-class
- leave-active-class
- 

### 过渡的钩子


-   v-on:before-enter="beforeEnter"
-   v-on:enter="enter"
-   v-on:after-enter="afterEnter"
-   v-on:enter-cancelled="enterCancelled"
-   v-on:before-leave="beforeLeave"
-   v-on:leave="leave"
-   v-on:after-leave="afterLeave"
-   v-on:leave-cancelled="leaveCancelled"
-   

> 推荐对于仅使用 JavaScript 过渡的元素添加 v-bind:css="false"，Vue 会跳过 CSS 的检测。这也可以避免过渡过程中 CSS 的影响。


### 初始化过渡


可以通过 appear 特性设置节点的在初始渲染的过渡


## 列表过渡

> <transition-group>
不同于 <transition>， 1.它会以一个真实元素呈现：默认为一个 <span>。你也可以通过 tag 特性更换为其他元素。
内部元素 总是需要 提供唯一的 key 属性值

### 列表的偏移

> <transition-group> 组件还有一个特殊之处。不仅可以进入和离开动画，还可以改变定位。要使用这个新功能只需了解新增的 v-move 特性，它会在元素的改变定位的过程中应用。像之前的类名一样，可以通过 name 属性来自定义前缀，也可以通过 move-class 属性手动设置。