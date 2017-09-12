## vue自定义指令

注册一个全局的指令

    Vue.directive('focus', {
      // 当绑定元素插入到 DOM 中。
      inserted: function (el) {
        // 聚焦元素
        el.focus()
      }
    })
    
注册到局部的指令

    directives: {
      focus: {
        // 指令的定义---
      }
    }
    
    
    
## 钩子函数


指令定义函数提供了几个钩子函数（可选）：
- bind: 只调用一次，指令第一次绑定到元素时调用，用这个钩子函数可以定义一个在绑定时执行一次的初始化动作。
- inserted: 被绑定元素插入父节点时调用（父节点存在即可调用，不必存在于 document 中）。
- update: 被绑定元素所在的模板更新时调用，而不论绑定值是否变化。通过比较更新前后的绑定值，可以忽略不必要的模板更新（详细的钩子函数参数见下）。
- componentUpdated: 被绑定元素所在模板完成一次更新周期时调用。
- unbind: 只调用一次， 指令与元素解绑时调用。
- 

## 钩子参数


钩子函数被赋予了以下参数：
- el: 指令所绑定的元素，可以用来直接操作 DOM 。
- binding: 一个对象，包含以下属性：
- 
   -  name: 指令名，不包括 v- 前缀。
   -  value: 指令的绑定值， 例如： - v-my-directive="1 + 1", value 的值是 2。
   -  oldValue: 指令绑定的前一个值，仅在 update 和 componentUpdated 钩子中可用。无论值是否改变都可用。
    - expression: 绑定值的字符串形式。 例如 - v-my-directive="1 + 1" ， expression 的值是 "1 + 1"。
    - arg: 传给指令的参数。例如 - v-my-directive:foo， arg 的值是 "foo"。
    - modifiers: 一个包含修饰符的对象。 例如： - v-my-directive.foo.bar, 修饰符对象 
    - modifiers 的值是 { foo: true, bar: true }。

vnode: Vue 编译生成的虚拟节点，查阅 VNode API
了解更多详情。
oldVnode: 上一个虚拟节点，仅在 update 和 componentUpdated 钩子中可用。

        directives:{
            'test':{
                "bind":function (el, binding, vnode) {
                    console.log(el)
                },
                "inserted":function (el, binding, vnode) {
                        console.log(el)
                }
            }
        }
        
        
### 对象字面量

如果指令如果传入多个值的时候，可以传入一个对象。

         <div v-test="{user:'xiaowang'}"></div>