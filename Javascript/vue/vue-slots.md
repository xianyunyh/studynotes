## 匿名插槽

```vue
//child.vue
<template>
  before
  <slot></slot>
  after
</template>

// farther

<template>
<child>
  hello world
</child>

</template>

```

## 具名插槽

```vue
<template>

<div>

<slot name="header"></slote>
</div>

</template>


<template>
<child #header></child>

</template>
```

## 插槽传值

```vue
<template>
<div>
  <slot v-slot="{user:{}}"></slot>
</div>

</template>


<template>
<current-user #default="{ user }">
  {{ user.firstName }}
</current-user>
</template>
```
