## Provide / Inject

当我们通过父组件向子组件传递数据，可以通过`props` 但是如果我们向子组件的下级的下级传递，如果通过props一层层的传递，非常麻烦。我们可以通过`provide`进行包裹

这样父节点下面的所有节点就能拿到对应的数据。

```vue
// parent
<script lang="ts">
import { defineComponent, reactive,provide } from 'vue'
import HelloWord from './components/HelloWorld.vue'
export default defineComponent({
  components: {HelloWord},
  setup() {
    const user = reactive({
      name : '',
      age: 10,
    })
    provide("user",readonly(user))
    return {}
  },
})
</script>
// son


<script lang="ts">
import { defineComponent, inject } from "vue";

export default defineComponent({
  inject: ["user"],
  setup() {
    return {
      user: inject("user"),
    };
  },
});
</script>
```

