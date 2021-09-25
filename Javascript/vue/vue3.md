## composition-api 组合式api

`setup` 是组合式api的入口。

对比vue2 和vue3

```js
export default {
    props: {
        user: {
            type: String,
            requied: true,
        }
    },
    watch: {
        user(value){
            
        }
    },
    data(){
        return {
            state: {
                b: 1,
                c: [],
            },
            student: {
                name: "",
                age: 10,
            }
        }
    },
    mounted() {},
    created() {},
    methods: {
        click() {
            this.state.b++
            this.student.age++
        }
    },
    
}
```



```js
import { defineComponent, reactive, ref, toRefs,Ref,onMounted,watch,computed } from 'vue'
export default {
  props: {
    user: {
      type: String,
      required: true
    }
  },
  setup() {
    const state = reactive({
      b: 1,
      c: []
    })
    const student = reactive({
      name: "",
      age: 10,
    })
    onMounted(()=>{
      console.log("mounted")
    })
    const click = () => {
      state.b++
      student.age++
    }
    const msg = ref("hello world")
    const callback = (val: string) => {
      msg.value = val
    }
    const u = computed(()=>student.age+1)
    watch(user,(value)=>{
      console.log(value)
    })
      // 这里返回的任何内容都可以用于组件的其余部分
    return {
      ...toRefs(state),
      click,
      student,
      callback,
      msg,
        u
    }
  },
}
```



### 响应式变量

#### ref

`ref` 的作用就是**将一个原始数据类型 转换成一个带有**[响应式特性(reactivity)](https://v3.vuejs.org/guide/reactivity.html#what-is-reactivity)的数据类型，原始数据类型共有7个，分别是：

- String
- Number
- BigInt
- Boolean
- Symbol
- Null
- Undefined

**ref 的注意事项**

- 在 setup() 函数内，由 ref() 创建的响应式数据返回的是对象，所以需要用 .value 来访问；
- 而在 setup() 函数外部则不需要 .value ，直接访问即可。
- 可以在 reactive 对象中访问 ref() 函数创建的响应式数据。
- 新的 ref() 会覆盖旧的 ref() 。

```vue
<script>
import {ref} from 'vue'
export default{
    setup(){
        const a = ref("")
        a.value = "1"//需要用.value
        return {
            a
        }
    }
    
}
</script>
<template>
<h2>
    {{a}}
    </h2>
</template>
```

#### reactive

Vue3提供了一个方法：`reactive` （等价于Vue2中的`Vue.observable()` ）来赋予*对象(Object)* 响应式的特性 



**toRefs**，它可以将一个响应型对象(reactive object)转化为普通对象(plain object)，同时又把该对象中的每一个属性转化成对应的响应式属性(ref)。对象里的属性赋予响应式特性(reactivity)

```vue
<template>
  {{user.age}}
	<p>
        {{age}}
    </p>
</template>

<script>
import { defineComponent, reactive, ref, toRefs,Ref,onMounted,watch } from 'vue'
export default {
    setup() {
        const user = reactive({
            name:'',
            age: 10
        })
        return {
            user,
            ...toRefs(user),
        }
    }
}
</script>

<style>

</style>
```



### computed 计算属性

vue3中计算是独立的，从 Vue 导入的 `computed` 函数在 Vue 组件外部创建计算属性 



```js
import {comptued} from 'vue'
setup(){
    const age = ref(1)
    const newAge = computed(()=>age+1)
    return {newAge}
}
```

### watch 监听

```js
import { ref, watch } from 'vue'

setup() {
    const counter = ref(0)
    watch(counter, (newValue, oldValue) => {
      console.log('The new counter value is: ' + counter.value)
    })
}
```

### 生命周期函数

| 选项式 API        | 组合式API `setup`   |
| ----------------- | ------------------- |
| `beforeCreate`    | --                  |
| `created`         | --                  |
| `beforeMount`     | `onBeforeMount`     |
| `mounted`         | `onMounted`         |
| `beforeUpdate`    | `onBeforeUpdate`    |
| `updated`         | `onUpdated`         |
| `beforeUnmount`   | `onBeforeUnmount`   |
| `unmounted`       | `onUnmounted`       |
| `errorCaptured`   | `onErrorCaptured`   |
| `renderTracked`   | `onRenderTracked`   |
| `renderTriggered` | `onRenderTriggered` |
| `activated`       | `onActivated`       |
| `deactivated`     | `onDeactivated`     |

> `setup` 是围绕 `beforeCreate` 和 `created` 生命周期钩子运行的，所以不需要显式地定义它们。换句话说，在这些钩子中编写的任何代码都应该直接在 `setup` 函数中编写。 



```js
import {onMounted} from 'vue'
export default {
  setup() {
    // mounted
    onMounted(() => {
      console.log('Component is mounted!')
    })
  }
}
```

### props

setup 中可以有两个参数 第一个参数就是 props

> 因为 `props` 是响应式的，你**不能使用 ES6 解构**，它会消除 prop 的响应性。 

如果需要解构。应该使用`toRefs`来解决



```js
import {toRefs} from 'vue'
export default {
    props: {
        user:{
            type:  String,
        	default: ""
        }
    }
   setup(props) {
    const {user} = toRefs(props)
} 
}

```

### context

传递给 `setup` 函数的第二个参数是 `context`。`context` 是一个普通的 JavaScript 对象，它暴露组件的三个 property： `attrs` 、`slots` 、`emit`

**context 解释**

- context.emit === this.$emit
- context.slots === this.slots

```js
export default {
  setup(props, context) {
    // Attribute (非响应式对象)
    console.log(context.attrs)

    // 插槽 (非响应式对象)
    console.log(context.slots)

    // 触发事件 (方法)
    console.log(context.emit)
  }
}
```

