## get 和 set

get 语法将一个对象属性绑定到查询该属性时将被调用的一个函数上。
	
	{get prop() { ... } }
	
	{get [expression]() { ... } }

注意事项

- 可以使用数值或字符串作为标识
- 必须不带参数
- 在对象字面量中,同一个属性不能有两个get,也不能既有get又有属性键值对(不允许使用 { get x() { }, get x() { } } 和 { x: ..., get x() { } } )


	var user = {
		"first_name":"张",
		"second_name":"三",
		get fullName(){
			return this.first_name+this.second_name
		}
	}
	console.log(user.fullName)

### 使用delete 删除getter

	delete user.fullName;


## setter 

> set  语法将对象属性绑定到要调用的一个函数上， 当尝试设置该属性时

	{set prop(val) { . . . }}

### 注意事项

1. 它的标识符可以是 number 与 string 二者之一
2. 必须有一个参数
3. 不能存在两个set和为一个已经存在的属性设置setter


		var user = {
		"first_name":"张",
		"second_name":"三",
		get fullName(){
			return this.first_name+this.second_name
		},
		set fullName(name){
			this.first_name ="王"
		}
	}
	user.fullName = "11";
	console.log(user.fullName)//王三