## Vue cli3 proxy
在前端的开发过程中，有时候需要进行调后端的接口，但是我们经常会遇到一个跨域的问题。在开发的过程中。可以通过proxy。来实现跨域。
在vue cli3 中实现可以在配置中。加下以下设置

```js
module.exports = {
  devServer: {
    proxy: {
      '/api': {
        target: 'https://api.somewhere.com', # 测试环境接口地址
        secure: true,
        pathRewrite: {
          '^/api': '',
        },
      }
    },
  },
}

```
然后在我们的接口请求中，以`axios`为例 只需要把 `baseURL` 改成本地的`/api` 即可

`/user` 则会转发到`https://api.somewhere.com/user`
```js
axios.get('/api/user')
```
