## if

```
if [[condition]];then

fi

//if else

if [[condition]]; then

else

fi

# if elseif else

if [[condition]];then


elif [[condition]];then

fi




```

## for 

```

for i in list1 list2 ;do
    echo $i
done

for i in 1 2 3 4;do

    echo $i
done
//1 2 3 4

for (( i = 0; i < 10; i++ )); do
	echo $i
done

```

## while


```

while [[ condition ]]; do
	#statements
done


```

### 例子

```
#! /bin/bash

a=10
b=20

# 判断数值
if [[ $a -ne $b ]]; then
    echo "a 不等于b"
fi

# 判断字符串
if [[ '$a' != '$b' ]]; then
    echo "1"
fi

# 判断文件

if [[  -d "../doc" ]]; then
    echo "dirctory"
fi

if [[ ! -f "../routes" ]]; then
    echo "not a file"
fi


#while
while [[ $a -gt 1   ]]; do
    #statements
    echo $a;
    # 条件
    let a--
done

# for

for i in "wo" "rds"; do
    echo $i
done
```