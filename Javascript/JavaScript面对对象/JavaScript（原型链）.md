## js 原型链

instanceof表示的就是一种继承关系，或者原型链的结构

Instanceof运算符的第一个变量是一个对象，暂时称为A；第二个变量一般是一个函数，暂时称为B。

Instanceof的判断队则是：沿着A的__proto__这条线来找，同时沿着B的prototype这条线来找，如果两条线能找到同一个引用，即同一个对象，那么就返回true。如果找到终点还未重合，则返回false。

```
function Person() {

}

var person = new Person()

person.__proto__ === Person.prototype

Person.prototype.constructor === Person


```
蓝色__proto__ 就是js原型链

person 是一个实例对象。

![image](http://images2015.cnblogs.com/blog/787416/201603/787416-20160323103557261-114570044.png)

![image](https://github.com/mqyqingfeng/Blog/raw/master/Images/prototype5.png)

### 实例与原型

当读取实例的属性时，如果找不到，就会查找与对象关联的原型中的属性，如果还查不到，就去找原型的原型，一直找到最顶层为止

```
function Person(){
    
}

var person = new Person()

person.name = '张三'

Person.prototype.age = 11


Object.prototype.sex = '1'

person.name //张三

person.age // 11

person.sex //1 object 原型上的

```

![image](http://images2015.cnblogs.com/blog/787416/201603/787416-20160323103622089-1134417169.png)

![image](http://images2015.cnblogs.com/blog/787416/201603/787416-20160322110905589-2039017350.png)

