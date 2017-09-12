## python file

- 读取文件

```
 fp = open(filename,'w+',encoding='utf-8')
 fp.read()
 ```
 
 - 写入文件
 
```
fp.write(data)

```

```

with open(filename) as fp:
    fp.read()
    fp.close()
```