## vue混合

混合是一种灵活的分布式复用 Vue 组件的方式。混合对象可以包含任意组件选项。以组件使用混合对象时，所有混合对象的选项将被混入该组件本身的选项。


      let mix = {
            created:function(){
                console.log('create')
            }
        }
        let component = Vue.extend({
            mixins:[mix]
        })
        let vm = new component()
    
        let vm2 = new Vue({
            mixins:[
                {
                    "created":function () {
                        console.log('test')
                    }
                }
            ]
        })
        
        
> 值为对象的选项，例如 methods, components 和 directives，将被混合为同一个对象。 两个对象键名冲突时，取组件对象的键值对。