## x-template 

一种定义模版的方式是在 JavaScript 标签里使用 text/x-template 类型，并且指定一个id

    <script type="text/x-template" id="test">
      <p>Hello hello hello</p>
    </script>
    
    var vm = new Vue({
        components:{
            "test":{
                "template":"#test"
            }
        }
    })
    
    
## inline-template

> 如果子组件有 inline-template 特性，组件将把它的内容当作它的模板，而不是把它当作分发内容。这让模板更灵活

      <inline inline-template>
        <ul>
            <li>11</li>
            <li>33</li>
        </ul>
    </inline>
    
    let vm = new Vue({
        el:"#app",
        data:{

        },
        components:{
            "inline":{
                "template":"<div></div>"
            }
        }


    })