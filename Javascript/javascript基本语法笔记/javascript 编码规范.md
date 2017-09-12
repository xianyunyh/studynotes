## javascript 编码规范

1. 使用空格代替tab键

2. JavaScript会自动添加句末的分号，导致一些难以察觉的错误。区块起首的大括号，不要另起一行

```
//good
var obj = {
    
}
//bad
var obj = 
{
    
}
```
3. 圆括号

表示函数调用时，函数名与左括号之间没有空格。

表示函数定义时，函数名与左括号之间没有空格。

其他情况时，前面位置的语法元素与左括号之间，都有一个空格。


```
function f(){}
f()
(a+b) * 3 //有空格


```

4. 行尾分号不要省略

5. 全局变量 尽量不要使用全局变量 如果不得不使用，用大写字母表示变量名 PATH_NAME

5. 变量声明 

为了减少未知的错误，变量最好提前声明。

6. 不要使用with语句
7. 相等和严格相等 尽量选择后者
8. 自增使用+=代替
9. swtich case语句


switch...case结构要求，在每一个case的最后一行必须是break语句，否则会接着运行下一个case。这样不仅容易忘记，还会造成代码的冗长

```
function doAction(action) {
  switch (action) {
    case 'hack':
      return 'hack';
      break;
    case 'slash':
      return 'slash';
      break;
    case 'run':
      return 'run';
      break;
    default:
      throw new Error('Invalid action.');
  }
}

//建议写成下面的格式

function doAction(action) {
  var actions = {
    'hack': function () {
      return 'hack';
    },
    'slash': function () {
      return 'slash';
    },
    'run': function () {
      return 'run';
    }
  };

  if (typeof actions[action] !== 'function') {
    throw new Error('Invalid action.');
  }

  return actions[action]();
}
```